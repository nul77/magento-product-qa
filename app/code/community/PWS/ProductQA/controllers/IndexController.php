<?php
class PWS_ProductQA_IndexController extends Mage_Core_Controller_Front_Action
{
   
   public function addQuestionAction()
    {
        $post = $this->getRequest()->getPost();
        if ( $post ) {
           
            try {
                $postObject = new Varien_Object();
                $postObject->setData($post);

                $error = false;

                if (!Zend_Validate::is(trim($post['name']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['question']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                    $error = true;
                }

                if (Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
                    $error = true;
                }

                if ($error) {
                    throw new Exception();
                }
                
                $post['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $productqa = Mage::getModel('pws_productqa/productqa');
                $productqa->setData($post);
                $productqa->save();
                

                Mage::getSingleton('catalog/session')->addSuccess(Mage::helper('pws_productqa')->__('Thank You! We\'ll reply to your question as soon as possible '));
                
                return $this->_redirectReferer();
            } catch (Exception $e) {               

                Mage::getSingleton('catalog/session')->addError(Mage::helper('pws_productqa')->__('Unable to submit your question. Please, try again later'.$e->getMessage()));
                
                return $this->_redirectReferer();
            }

        } else {
            return $this->_redirectReferer();
        }
    }

   
   
}
