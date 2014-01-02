====================[Rails SLS Modules]=========================
All files in this folder should adhere to the following policies:

	1.  Any Database connection should be made through the Database Module (this allows swapable db's)
	2.  Modules should only extend the SLS interface, they should not require that the module be there to run
	3.  Each module shall be kept in its own folder
	4.  Each module will require the file init.php which the module loader will look for
	5.  