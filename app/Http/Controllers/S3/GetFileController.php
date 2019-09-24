<?php
namespace App\Controller\S3;

use App\Controller\AbstractActionController;
use Aws\Exception\AwsException;
use S0mWeb\WTL\StdLib\ServiceLocatorAwareInterface;
use S0mWeb\WTL\StdLib\ServiceLocatorAwareTrait;

class GetFileController extends AbstractActionController implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function getFile()
    {
        $encodedFileName = $this->params()->fromRoute('fileName');
        $fileName = base64_decode($encodedFileName);

        /** @var \S0mApi\Service\AWS\S3\S3 $service */
        $service = $this->getServiceLocator()->get(\S0mApi\Service\AWS\S3\S3::class);
        try {
            $result = $service->openFile($fileName);
        } catch (AwsException $e) {
            return $this->notFoundAction();
        }

        $file = $result->get('Body')->getContents();
        $mimeType = $result->get('ContentType');
        header('Content-Description: File Transfer');
        header("Content-Transfer-Encoding: binary");
        header('Content-Type: '.$mimeType);
        header('Content-length: ' . strlen($file));
        header('Content-Disposition: inline');
        echo $file;
    }
}
