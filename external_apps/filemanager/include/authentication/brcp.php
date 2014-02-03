<?php
if( !defined( '_JEXEC' ) && !defined( '_VALID_MOS' ) ) die( 'Restricted access' );
//Load in the appropriate models and configs from BRCP
//$path = "C:/wamp/www/";// For FirePHP
//require_once($path."FirePHPCore/FirePHP.class.php");

class ext_brcp_authentication
{
	function onAuthenticate($credentials,$options=null)
	{
			
			$credentials["username"] = $_REQUEST["username"];
			$credentials["domain"] = $_REQUEST["domain"]."user/verify_login_json";
			
			$connection = curl_init($credentials["domain"]);
			$fields = array("session_id"=>urlencode($credentials["username"]));
			$fields_string = "";
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			curl_setopt($connection,CURLOPT_URL,$credentials["domain"]);
			curl_setopt($connection,CURLOPT_POST,count($fields));
			curl_setopt($connection,CURLOPT_POSTFIELDS,$fields_string);
			curl_setopt ($connection, CURLOPT_RETURNTRANSFER, true);

			$result = curl_exec($connection);
			//ob_start();
			//$firephp = FirePHP::getInstance(true);
			//$firephp->log($_REQUEST["username"],"USERNAME");
			//$firephp->log($credentials["domain"],"Domain");
			//$firephp->log($result,"Result");
			$json = json_decode($result,true);
			//$firephp->log($json,"JSON");

			//TODO: FIX THIS.
			if(isset($json) && $json["logged_in"] ==  true)
			{
				$data=ext_find_user( "admin",null );
				require_once( _EXT_PATH.'/libraries/PasswordHash.php');
				$hasher = new PasswordHash(8, FALSE);
				$result = $hasher->CheckPassword("admin", $data[1]);
				$_SESSION['file_mode']='extplorer';
				//$data=ext_find_user( "admin","admin" );
				$_SESSION['credentials_extplorer']['username']	= $data[0];
				$_SESSION['credentials_extplorer']['password']	= $data[1];
				//$_SESSION['file_mode'] = 'extplorer';
				$GLOBALS["home_dir"]	= str_replace( '\\', '/', $data[2] );
				$GLOBALS["home_url"]	= $data[3];
				$GLOBALS["show_hidden"]	= $data[4];
				$GLOBALS["no_access"]	= $data[5];
				$GLOBALS["permissions"]	= $data[6];
				
				//die("User is signed in");
				return true;
			}
		return false;
	}
	
		function onShowLoginForm() {
		?>
	{
		xtype: "form",
		<?php if(!ext_isXHR()) { ?>renderTo: "adminForm", <?php } ?>
		title: "<?php echo ext_Lang::msg('actlogin') ?>",
		id: "simpleform",
		labelWidth: 125, // label settings here cascade unless overridden
		url: "<?php echo basename( $GLOBALS['script_name']) ?>",
		frame: true,
		keys: {
		    key: Ext.EventObject.ENTER,
		    fn  : function(){
				if (simple.getForm().isValid()) {
					Ext.get( "statusBar").update( "Please wait..." );
					Ext.getCmp("simpleform").getForm().submit({
						reset: false,
						success: function(form, action) { location.reload() },
						failure: function(form, action) {
							if( !action.result ) return;
							Ext.Msg.alert('<?php echo ext_Lang::err( 'error', true ) ?>', action.result.error, function() {
							}, form );
							Ext.get( 'statusBar').update( action.result.error );
						},
						scope: Ext.getCmp("simpleform").getForm(),
						params: {
							option: "com_extplorer", 
							action: "login",
							type : "extplorer"
						}
					});
    	        } else {
        	        return false;
            	}
            }
		},
		items: [ {
            xtype:"textfield",
			fieldLabel: "<?php echo ext_Lang::msg( 'miscusername', true ) ?>",
			name: "username",
			width:175,
			allowBlank:false,
			value:"<?php echo $_GET["username"]; ?>"
		},
		{
            xtype:"textfield",
			fieldLabel: "<?php echo ext_Lang::msg( 'domain', true ) ?>",
			name: "domain",
			width:175,
			allowBlank:false,
			value:"<?php echo $_GET["domain"]; ?>"
		},
		new Ext.form.ComboBox({
			
			fieldLabel: "<?php echo ext_Lang::msg( 'misclang', true ) ?>",
			store: new Ext.data.SimpleStore({
		fields: ['language', 'langname'],
		data :	[
		<?php 
		$langs = get_languages();
		$i = 0; $c = count( $langs );
		foreach( $langs as $language => $name ) {
			echo "['$language', '$name' ]";
		if( ++$i < $c ) echo ',';
		}
		?>
			]
	}),
			displayField:"langname",
			valueField: "language",
			value: "<?php echo ext_Lang::detect_lang() ?>",
			hiddenName: "lang",
			disableKeyFilter: true,
			editable: false,
			triggerAction: "all",
			mode: "local",
			allowBlank: false,
			selectOnFocus:true
		}),
		{
			xtype: "displayfield",
			id: "statusBar"
		}
		],
		buttons: [{
			text: "<?php echo ext_Lang::msg( 'btnlogin', true ) ?>", 
			type: "submit",
			handler: function() {
				Ext.get( "statusBar").update( "Please wait (BRCP)..." );
				Ext.getCmp("simpleform").getForm().submit({
					reset: false,
					success: function(form, action) { location.reload() },
					failure: function(form, action) {
						if( !action.result ) return;
						Ext.Msg.alert('<?php echo ext_Lang::err( 'error', true ) ?>', action.result.error, function() {
							}, form );
						Ext.get( 'statusBar').update( action.result.error );
						
					},
					scope: Ext.getCmp("simpleform").getForm(),
					params: {
						option: "com_extplorer", 
						action: "login",
						type : "brcp"
					}
				});
			}
		},<?php if(!ext_isXHR()) { ?>
		{
			text: '<?php echo ext_Lang::msg( 'btnreset', true ) ?>', 
			handler: function() { simple.getForm().reset(); } 
		}
		<?php 
		} else {?>
		{
			text: "<?php echo ext_Lang::msg( 'btncancel', true ) ?>", 
			handler: function() { Ext.getCmp("dialog").destroy(); }
		}
		<?php 
		} ?>
		]
	}
	<?php
	}
	
	function onLogout()
	{
	}
}