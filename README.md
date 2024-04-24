[![N|Solid](https://www.maib.md/images/logo.svg)](https://www.maib.md)

# Maib Payment Gateway Module for CS-Cart platform
Accept Visa / Mastercard / Apple Pay / Google Pay on your store with the Maib Payment Gateway Module for CS-Cart platform

## Description
You can familiarize yourself with the integration steps and website requirements [here](https://docs.maibmerchants.md/en/integration-steps-and-requirements).

To test the integration, you will need access to a Test Project (Project ID / Project Secret / Signature Key). For this, please submit a request to the email address: ecom@maib.md.

To process real payments, you must have the e-commerce contract signed and complete at least one successful transaction using the Test Project data and test card details.

After signing the contract, you will receive access to the maibmerchants platform and be able to activate the Production Project.

## Functional
**Online payments**: Visa / Mastercard / Apple Pay / Google Pay.

**Three currencies**: MDL / USD / EUR (depending on your Project settings).

**Payment refund**: To refund the payment it is necessary to update the order status (see _refund.png_) to the selected status for _Refunded payment_ in **Maib Payment Gateway Module** extension settings (see _settings-1.png_ and _settings-2.png_). The payment amount will be returned to the customer's card.

## Requirements
- Registration on the maibmerchants.md
- CS-Cart platform (version > 4.7.2)
- _curl_ and _json_ extensions enabled

## Installation
1. Download the extension file from Github or CS-Cart repository.
2. In the CS-Cart Admin Panel/Admin UI, go to _Add-ons_.
3. Search if the input field "maib" or find the **Maib Payment Gateway Module** add-on in the list.
4. Click the _Install_ button and CS-Cart will start the installation process.
5. After you see that add-on was successfully installed, go to _Administration_ > _Payment methods_ and click to "+" (add payment method).
6. At the _Processor_ dropdown list from _General_ tab search or find **MAIB** and select it. New tab _Configure_ will appear.
7. At the _Configure_ tab you will see two sections: _Configuration maibmerchants.md_ and _Configuration Order Status_. Complete all necessary fields and click to _Create_ button.

## Settings
1. Project ID - Project ID from maibmerchants.md
2. Project Secret - Project Secret from maibmerchants.md. It is available after project activation.
3. Signature Key - Signature Key for validating notifications on Callback URL. It is available after project activation.
4. Ok URL / Fail URL / Callback URL - add links in the respective fields of the Project settings in maibmerchants.
5. Order status settings: Pending payment - Order status when payment is in pending.
6. Order status settings: Completed payment - Order status when payment is successfully completed.
7. Order status settings: Failed payment - Order status when payment failed.
8. Order status settings: Refunded payment - Order status when payment is refunded. For payment refund, update the order status to the this selected status (see _refund.png_).

## Troubleshooting
If you require further assistance, please don't hesitate to contact the **Maib Payment Gateway Module** ecommerce support team by sending an email to ecom@maib.md. 

In your email, make sure to include the following information:
- Merchant name
- Project ID
- Date and time of the transaction with errors
- Errors from log file