Self-hosted PHP code / pixel for retargeting in DFP
=========================

Repository with a PHP code that allows creation of custom audience segments based on self-hosted retargeting pixels

Two approaches - for publishers with one, common domain **[oneDomain]** and for multiple domains **[multipleDomains]**.

Most of the code is shared between the two.

1. CookieCreator.php - server side code responsible for creating and managing a cookie.
2. cookieMuncher.js - client side code responsible for reading cookie and passing variables + setting targeting for DFP.
3. multipleDomains_example.html and oneDomain_example.html - example integration with 300x600 and 160x600 ad formats.
4. rtgt.php - server-side code allowing to place cookie content set by CookieCreator on another domain, allowing to pass retargeting settings.

--------------------------------------------------------------------------------

### Walkthrough, how to set up: ###

1. PHP server is needed (recommended version PHP 5.6.4)
2. This example assumes the publisher is using DFP, but code should work in a similar manner with any other key=value based adserving technology
3. For a detailed walkthrough on how to set on DFP end please go here:

- prepare inventory: https://support.google.com/dfp_sb/answer/2983838?hl=en
- more about key-value targeting https://support.google.com/dfp_premium/answer/177383?hl=en#custom
- screenshots showing how to set a campaign in DFP in section below

### Important notes: ###
1. For an example on how to extract key=values & how to pass it to DFP - please see **cookieMuncher.js** file
2. For multiple domains example - do note, that **rtgt.php** script file must be loaded as quickly as possible in order to correctly pass data. The rest is basically identical

--------------------------------------------------------------------------------
### Example implementation - ad delivery: ###
[Example website using **[oneDomain]** implementation](https://adserve.pl/CookieMonster/oneDomain_example.html) 

[Example website using **[multipleDomains]** implementation](https://storage.googleapis.com/adpage/multipleDomains_example.html)

--------------------------------------------------------------------------------

### Assumptions: ###
1. Cookie is updated only server-side. 
2. Cookie default lifetime is set to 14 days. If marked user is not marked again or unmarked - cookie is deleted

--------------------------------------------------------------------------------

### Example key=value campaign set up in DFP: ###

1) After creating an order add a new line item for each key=value targeting. 
Good practise is to use only one ad format for each line item in inventory size settings.

**Example** If you want to create line items targeted to
```
retarget=example_160x600
```
and 

```
retarget=example_300x600
```
 
you will need to create two line items targeted separately.

![Screenshot 1](/screenshots/targeting_1.png "Inventory size settings")

--------------------------------------------------------------------------------

2) Use highest possible priority available in your ad environment. Targeting on selected audience limits reach so highest possible priority will push delivery and spend. 

![Screenshot 2](/screenshots/targeting_2.png "Priority settings")

--------------------------------------------------------------------------------

3) For testing purposes please use capping. 

**Example** 5 impressions per 1 day 

![Screenshot 3](/screenshots/targeting_3.png "Optional Title")

--------------------------------------------------------------------------------

4) In targeting settings choose key=value parameter (in this particular case **retarget is example_160x600**) and set it to Run Of Network.
![Screenshot 4](/screenshots/targeting_4.png "Optional Title")

--------------------------------------------------------------------------------
5) Save and congratulations! After attaching creatives your DFP line item should start delivery to your custom pixel-based audience
