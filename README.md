# PowerToys Client - plesk version

Custom rest api client created to communicate with powertoys rest api server.

This version of client is updated directly for plesk extension development.

# Integrate in custom plesk extension
To integrate our library in custom plesk extension you will need to make some changes.

1. Change the class name with your plesk extension id.
2. Add our library to <b>{extensionFolder}</b>/plib/library
3. Use powertoys client in your extension

# Change the class name with your plesk extension
Change the PowertoysClient class name to Modules_<b>{EXTENSION_ID}</b>_PowertoysClient

The extension id can be found in your meta.xml -> id our name is ( power-toys this will generate PowerToys )
Note the class name will change the - with big character

# Add our library to your extension
After changing the name of the class you will need to move it into your extension library folder

If you don't have library folder you will need to create one in extension plib folder,
then copy the library there. 

<b>Whoala you can use it in your extension</b>

# Use powertoys client in your extension
To use powertoys client extension you just neew to do the following steps

$powertoysClient = new Modules_<b>{EXTENSION_ID}</b>_PowertoysClient(<b>{hash}</b>, <b>{version}</b>);


# Issues
If you have any issue please create an issue and I will try to help you out in the next 48 hours.

# Bugfixing
If you have any bug fixes done or any updates that would help this client please feel free to create a pull request.

Thank you,<br/>
Tamas


