<?php

namespace SPW;

class Files
{
    public static function getErrorMessage($error)
    {
        switch ($error)
        {
            case UPLOAD_ERR_INI_SIZE :   return "Le fichier est trop volumineux, ".(\SPW\Files::getMaxUploadSize() / 1000000)." MO maximum autorisé.";
            case UPLOAD_ERR_FORM_SIZE :  return "Le fichier est trop volumineux.";
            case UPLOAD_ERR_PARTIAL :    return "Le fichier n'as pas été téléchargé entièrement.";
            case UPLOAD_ERR_NO_FILE :    return "Le fichier n'as pas été téléchargé.";
            case UPLOAD_ERR_NO_TMP_DIR : return "Dossier temporaire manquant, contactez l'administrareut du site.";
            case UPLOAD_ERR_CANT_WRITE : return "Echec d'écriture sur le disque, contactez l'administrareut du site.";
            case UPLOAD_ERR_EXTENSION :  return "L'extension du fichier pose problème.";  
        }
        
        return '';
    }
    
    public static function getExtension($filename) {
        return strtolower(substr(strrchr($filename, '.'), 1));
    }
    
    public static function getExtentionFromMimeType($filedir)
    {
        switch(self::getMimeType($filedir))
        {
            case 'image/jpeg': return 'jpg';
            case 'image/png': return 'png';
            case 'image/gif': return 'gif';
            case 'application/pdf': return 'pdf';
        }
        return '';
    }
    
    public static function getMimeType($filedir) {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        return $finfo->file($filedir);
    }
    
    public static function validMimeType($filedir, $types)
    {
        $mimeType = self::getMimeType($filedir);
        
        if(is_array($types) && array_search($mimeType, $types) !== false) {
            return true;
        }
        
        if(is_string($types) && $mimeType == $types) {
            return true;
        }
        
        return false;
    }
    
    public static function validFileSize($filedir)
    {
        $size = filesize($filedir);
        
        return ($size <= self::getMaxUploadSize());
    }
    
    public static function getMaxUploadSize()
    {
        return min(
            (int)(ini_get('upload_max_filesize')), 
            (int)(ini_get('post_max_size')), 
            (int)(ini_get('memory_limit'))
        ) * 1000000;
    }
    
    public static function createDirIfNotExist($dir)
    {
        if(!file_exists($dir)){
            mkdir($dir, 0755, true);
        }
    }
}