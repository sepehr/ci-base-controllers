#CodeIgniter Base Controllers
CodeIgniter base controller classes for a better code structure and DRYer controller classes.

It takes advantage of PHP 5's autoloading capabilities to include a class file when that class is referenced, allowing CI libraries to extend classes that have not yet been loaded.

##Installation
* Move each file to its corresponding directory.
* Enable hooks in `application/config/config.php` file: `$config['enable_hooks'] = TRUE;`
* **Merge** repository's `hooks.php` config file with your own at `application/config/hooks.php` to avoid loosing your current hooks.
* If using **Modular Extensions** and you want the HMVC feature in place, Alter `MY_Model` to extend `MX_Controller` instead of `CI_Controller` class.

##Usage
* Move application common logic of controllers to `application/core/Public_Controller.php` or `application/core/Admin_Controller.php` files or make your own, e.g. `Accounts_Controller`.
* Alter application controller classes to extend either `Public_Controller` or `Admin_Controller` (or the one you make) instead of `CI_Controller` class.
* Sample controllers can be found in `core/sample/` directory.

##References and read more
[CodeIgniter Base Classes Revisited](http://www.highermedia.com/articles/nuts_bolts/codeigniter_base_classes_revisited)
[CodeIgniter Base Classes: Keeping it DRY](http://philsturgeon.co.uk/news/2010/02/CodeIgniter-Base-Classes-Keeping-it-DRY)
