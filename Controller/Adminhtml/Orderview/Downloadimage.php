<?php
namespace Chilliapple\Customizeproducts\Controller\Adminhtml\Orderview;
use Magento\Backend\App\Action;
class Downloadimage extends \Magento\Backend\App\Action
{
    public function execute() {
		
		$data = $this->getRequest()->getParams();
		
		if ($data && $data['cid'] != '') {
			
			$downloadFilename = $data['name'];
			
			$model = $this->_objectManager->create('Chilliapple\Customizeproducts\Model\Customizecartdata');
			
			$rowData = $model->getCustomizedcartdata(array($data['cid']));
			
			if($rowData[0]) {
				
				$fileName = $rowData[0]['image_name'];
				
				if($fileName != '') {
					
					$mediaDir = $this->_objectManager->get('Magento\Framework\App\Filesystem\DirectoryList')->getPath('media');
					
					$fileNameCompl = $mediaDir."/customizeproducts/productimages/".$fileName.".png";
					
					if($downloadFilename != '') {
						$dfilename = $downloadFilename.'.png';
					} else {
						$dfilename = basename($fileNameCompl);
					}

					$this->getResponse()->setHttpResponseCode(200)->setHeader( 'Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true )
                    ->setHeader('Pragma', 'public', true)
                    ->setHeader('Content-type', 'application/force-download')
                    ->setHeader('Content-Length', filesize($fileNameCompl))
                    ->setHeader('Content-Disposition', 'attachment' . '; filename=' . $dfilename);
					$this->getResponse()->clearBody();
					$this->getResponse()->sendHeaders();
					readfile($fileNameCompl);
					
				}
				
			}
			
		}
    }
}
