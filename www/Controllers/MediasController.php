<?php

namespace ESGI\Controllers;

use ESGI\Core\Upload\Types\ImageUploadType;
use ESGI\Core\Upload\Types\VideoUploadType;
use ESGI\Core\Upload\Uploader;

class MediasController extends Controller
{
    public $security = [
        'indexAction' => 'medias.index',
        'listAction' => 'medias.index',
        'uploadAction' => 'medias.upload',
        'deleteAction' => 'medias.delete',
    ];

    public function indexAction(): void
    {
        $files = Uploader::getUploadedFiles();

        $this->render('medias.index', 'backend', ['files' => $files]);
    }

    public function listAction(): void
    {
        header('Content-Type: application/json');
        echo json_encode(Uploader::getUploadedFiles());
    }

    public function uploadAction(): void
    {
        // TODO: Auth & permissions

        $publicFileLink = Uploader::upload('file', [
            ImageUploadType::class,
            VideoUploadType::class
        ]);

        if (!isset($_GET['json'])) {
            // Send response.
            header('Content-Type: application/json');
            echo stripslashes(json_encode(['link' => $publicFileLink]));
        } else {
            redirect('medias.index');
        }
    }

    public function deleteAction(): void
    {
        $json = true;
        if (isset($_POST['src'])) {
            $formData = $_POST['src'];
        } elseif (isset($_GET['src'])) {
            $formData = $_GET['src'];
            $json = false;
        } else {
            $formData = json_decode(file_get_contents('php://input'), true);
            if (isset($formData['src'])) {
                $formData = $formData['src'];
            }
        }

        if ($formData) {
            $filePath = Uploader::getUploadPath() . basename($formData);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        if ($json) {
            header('Content-Type: application/json');
            echo stripslashes(json_encode(['success' => true]));
        } else {
            redirect('medias.index');
        }
    }
}
