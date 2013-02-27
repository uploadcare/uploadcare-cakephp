# CakePHP plugin for Uploadcare

This is a plugin for CakePHP framework to work with [Uploadcare][1]

It's based on a [uploadcare-php][4] library.

## Requirements

- CakePHP 2.2+
- PHP 5.2+
- php-curl

## Install 

Clone the repo:

    git clone git://github.com/uploadcare/uploadcare-cakephp.git plugins/Uploadcare --recursive

Unzip file to you CakePHP's plugin folder.

Inside your app/Config/bootstrap.php add:

    CakePlugin::load('Uploadcare');
    
Inside your app/Config/core.php add:

    Configure::write('uploadcare', array(
      'public_key' => 'demopublickey',
      'private_key' => 'demoprivatekey'
    ));
    
Change "demopublickey" and "demoprivatekey" to your own public and secret keys.

## Usage example

Plugin has a behavior and a helper.

Create some model and attach a behavior:

    class File extends AppModel
    {
      public $actsAs = array(
        'Uploadcare.Uploadcare' => array('file_id')
      );
    }
    
Behaviour takes an array of fields to be treated as file_id. You can pass as many fields as you can.

Create some controller that will handle the file the form. Add a helper Uploadcare.Uploadcare to it.

    class FilesController extends AppController {
      public $helpers = array('Html', 'Form', 'Uploadcare.Uploadcare');
      
      public function add() {
        if ($this->request->is('post')) {
          $this->File->create();
          if ($this->File->save($this->request->data)) {
            $this->Session->setFlash('Your post has been saved.');
            $this->redirect(array('action' => 'index'));
          } else {
            $this->Session->setFlash('Unable to add your post.');
          }
        }   
      }
    }

Create a View to display form with Uploadcare widget:

    <?php echo $this->Uploadcare->api()->widget->getScriptTag(); ?>
    <?php echo $this->Form->create('File', array('action' => 'add')); ?>
      <?php echo $this->Form->input('File.file_id', array('type' => 'hidden', 'role' => 'uploadcare-uploader')); ?>
    <?php echo $this->Form->end('Save!'); ?>
    
That's everything to be ready to upload. When controller will recieve a POST data and try to create new object,
the Uploadcare.Uploadcare behavior will handle all the fields you provided and store files for you.

## File operations

Uploadcare CDN provides a set of operations. You can easily use every operation inside your view or controller.

Create a controller. File model has a field "file_id":

    class FilesController extends AppController {
      public $helpers = array('Html', 'Form', 'Uploadcare.Uploadcare');
    
      public function index() {
        $this->set('files', $this->File->find('all'));
      }
    }
    
Inside view:

    <?php foreach ($files as $file): ?>
      <?php echo $this->Uploadcare->file($file['File']['file_id'])->scaleCrop(400, 400)->getImgTag(); ?>
    <?php endforeach; ?>
    
"Uploadcare" helper provides 2 basic methods. By calling

    $this->Uploadcare->api()
    
you will get an instance of Uploadcare_Api.
  
    $this->Uploadcare->file($file_id)
    
you will get an object of Uploadcare_File class.

You can find more about this classes at [uploadcare-php][4] main repo.

[More information on file operations can be found here][2]

[1]: https://uploadcare.com/
[2]: https://uploadcare.com/documentation/reference/basic/cdn.html
[3]: https://github.com/uploadcare/uploadcare-cakephp/downloads
[4]: https://github.com/uploadcare/uploadcare-php
