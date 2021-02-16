# Checkout-OC1.5
Checkout payment module for OpenCart 1.5 e-commerce software 

FEATURES:
- Uses new Checkout PSP API
- Save payment data to database
- Save transactions info to log file
- Save debug data
- Admin can check payment status in order info page

TESTED VERSIONS:
OpenCart 1.5.5.1, 1.5.6.4

REQUIREMENTS
- Default currency must be Euro (EUR)
- vQmod installed
- Needs a contract with the Checkout Finland Oy 

INSTALLATION:
1. Unzip installation package to your local computer.
2. Upload admin, catalog and vqmod folders to the OpenCart root directory.
3. Open checkout_style.txt file and copy it's contents to end of your template style file
4. Go to your OpenCart admin panel.
5. Go to System > Users > User Groups and set right permissions to folloving:
	- payment/checkout
6. Go to Extensions > Payments. Install and configure Checkout payment module.

UPDATING FROM OLDER VERSION (1.5.4 OR OLDER):
1. Go to Extensions > Payments. Uninstall Checkout payment module.
2. Unzip installation package to your local computer.
3. Upload admin, catalog and vqmod folders to the OpenCart root directory.
4. Open checkout_style.txt file and copy it's contents to end of your template style file
5. Go to your OpenCart admin panel.
6. Go to System > Users > User Groups and set right permissions to folloving:
	- payment/checkout
7. Go to Extensions > Payments. Install and configure Checkout payment module.
