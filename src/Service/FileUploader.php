<?php

namespace App\Service;

class FileUploader
{

    const MAX_FILE_SIZE = 1000000; // 1MB
    const ALLOWED_EXTENSIONS = ['image/jpg', 'image/jpeg', 'image/gif', 'image/png'];
    const UPLOAD_DIR = 'images/';

    /**
     * Upload un fichier et retourne soit le nom du fichier soit un tableau d'erreurs.
     * @param array $file Le fichier uploadé
     * @return mixed Le nom du fichier ou un tableau d'erreurs
     */
    public function upload($file): mixed
    {
        $errors = [];

        // Vérification si le fichier a été envoyé sans erreur
        if ($file['error'] != 0) {
            $errors["file"] = "Erreur lors de l'envoi du fichier.";
            return $errors;
        }

        // Vérification de la taille du fichier
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $errors["file"] = 'Le fichier est trop lourd, 1MB max.';
            return $errors;
        }

        // Vérification de l'extension
        $extension = $file['type'];
        if (!in_array($extension, self::ALLOWED_EXTENSIONS)) {
            $errors["file"] = 'Extension non autorisée, seuls les fichiers jpg, jpeg, gif et png sont acceptés.';
            return $errors;
        }

        // Si tout est valide, on déplace le fichier
        $uniqueName = uniqid() . basename($file['name']);
        $destination = self::UPLOAD_DIR . $uniqueName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            $errors["file"] = "Erreur lors du déplacement du fichier.";
            return $errors;
        } else {
            return $uniqueName; // Retourne simplement le nom du fichier
        }
    }

    /**
     * Supprime un fichier
     * @param string $filename Le nom du fichier à supprimer
     */
    public function delete(string $filename): void
    {
        $path = self::UPLOAD_DIR . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
    }
}
