#CodeIgniter Base Controllers
CodeIgniter base controller classes for a better code structure and DRYer controller classes.  

It takes advantage of PHP 5's autoloading capabilities to include a class file when that class is referenced, allowing CI libraries to extend classes that have not yet been loaded.

##Installation
* Move each file to its corresponding directory.
* Enable hooks in `application/config/config.php` file: `$config['enable_hooks'] = TRUE;`
* **Merge** repository's `hooks.php` config file with your own at `application/config/hooks.php` to avoind loosing your current hooks.

##Usage
* Move application common logic of controllers in `application/core/Public_Controller.php` or `application/core/Admin_Controller.php` files or make your own, e.g. `Accounts_Controller`.
* Make your application controller classes to extend either `Public_Controller` or `Admin_Controller` (or the one you make) instead of `CI_Controller` class.
```
    class Blog extends Public_Controller {
      function __construct()
      {
          parent::__construct();
          // Whatever
          $this->data['stuff'] = $whatever;
      }
    }
```

##References and read more
[CodeIgniter Base Classes: Keeping it DRY](http://philsturgeon.co.uk/news/2010/02/CodeIgniter-Base-Classes-Keeping-it-DRY)  
[CodeIgniter Base Classes Revisited](http://www.highermedia.com/articles/nuts_bolts/codeigniter_base_classes_revisited)  