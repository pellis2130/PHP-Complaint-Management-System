<?php

session_start();

require_once __DIR__ . '/../model/complaint.php';
require_once __DIR__ . '/../model/complaint_db.php';
require_once __DIR__ . '/../model/complaint_image_db.php';
require_once __DIR__ . '/../includes/validation.php';

if (
    !isset($_SESSION['customer_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Customer'
) {
    header("Location: ../view/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $productId = (int) ($_POST['product_id'] ?? 0);
    $complaintTypeId = (int) ($_POST['complaint_type_id'] ?? 0);
    $description = trim($_POST['description'] ?? '');

    /*
     * Validate required complaint information.
     */
    if (
        $productId <= 0 ||
        $complaintTypeId <= 0 ||
        !validateRequired($description)
    ) {
        header(
            "Location: ../view/new_complaint.php?error=1"
        );
        exit;
    }

    /*
     * Description is stored as TEXT.
     * Limit user input to 2,000 characters.
     */
    if (!validateLength($description, 1, 2000)) {
        header(
            "Location: ../view/new_complaint.php?error=description"
        );
        exit;
    }

    $customerId = (int) $_SESSION['customer_id'];

    /*
     * Check whether the customer uploaded an image.
     * Images are optional.
     */
    $hasImage = (
        isset($_FILES['complaint_image']) &&
        $_FILES['complaint_image']['error'] !==
            UPLOAD_ERR_NO_FILE
    );

    /*
     * Validate the image before saving
     * the complaint.
     */
    if ($hasImage) {

        $image = $_FILES['complaint_image'];

        /*
         * Make sure the upload completed.
         */
        if ($image['error'] !== UPLOAD_ERR_OK) {
            header(
                "Location: ../view/new_complaint.php?" .
                "image_error=upload"
            );
            exit;
        }

        /*
         * Limit image size to 5 MB.
         */
        if ($image['size'] > 5 * 1024 * 1024) {
            header(
                "Location: ../view/new_complaint.php?" .
                "image_error=size"
            );
            exit;
        }

        /*
         * Verify that the uploaded file
         * is actually an image.
         */
        $imageInfo = getimagesize(
            $image['tmp_name']
        );

        if ($imageInfo === false) {
            header(
                "Location: ../view/new_complaint.php?" .
                "image_error=type"
            );
            exit;
        }

        /*
         * Only allow JPEG, PNG, and GIF images.
         */
        $allowedTypes = [
            IMAGETYPE_JPEG => 'jpg',
            IMAGETYPE_PNG => 'png',
            IMAGETYPE_GIF => 'gif'
        ];

        if (!isset($allowedTypes[$imageInfo[2]])) {
            header(
                "Location: ../view/new_complaint.php?" .
                "image_error=type"
            );
            exit;
        }
    }

    /*
     * Create the complaint.
     */
    $complaint = new Complaint(
        null,
        $customerId,
        $productId,
        $complaintTypeId,
        null,
        $description,
        'Open'
    );

    /*
     * Save the complaint and get
     * the new complaint ID.
     */
    $complaintId = ComplaintDB::addComplaint(
        $complaint
    );

    if (!$complaintId) {
        header(
            "Location: ../view/new_complaint.php?error=1"
        );
        exit;
    }

    /*
     * Save the optional complaint image.
     */
    if ($hasImage) {

        $extension =
            $allowedTypes[$imageInfo[2]];

        /*
         * Create a safe unique filename.
         */
        $fileName =
            'complaint_' .
            $complaintId .
            '_' .
            uniqid() .
            '.' .
            $extension;

        $uploadFolder =
            __DIR__ . '/../uploads/complaints/';

        $destination =
            $uploadFolder . $fileName;

        /*
         * Move the image into the
         * complaint upload folder.
         */
        if (
            move_uploaded_file(
                $image['tmp_name'],
                $destination
            )
        ) {

            ComplaintImageDB::addImage(
                $complaintId,
                $fileName
            );

        } else {

            header(
                "Location: ../view/new_complaint.php?" .
                "image_error=save"
            );
            exit;
        }
    }

    /*
     * Complaint successfully submitted.
     */
    header(
        "Location: ../view/new_complaint.php?success=1"
    );
    exit;
}

header("Location: ../view/customer_home.php");
exit;

?>