# FreeScout Sidebar Webhook

Sidebar Webhook asynchronously injects HTML from your server into conversation sidebars.

This screenshot shows what it does: you can load any content on a per-customer, per-message basis from your own web server, asynchronously, every time a conversation is loaded on the screen.

In this picture, the kittens and text were loaded from an external server based on the customer's email address.

![with title](sidebar-with-title.png)
![without title](sidebar-without-title.png)

## Use cases

- Directly link to your customer management system
- Show details about order status live from your fulfillment system
- Quickly ship changes to your FreeScout system UI without updating modules
- Connect to backends using PHP/Node.js/Ruby/Perl/Rust/Go/Bash/Haskell and even Java

## Installation

These instructions assume you installed FreeScout using the [recommended process](https://github.com/freescout-helpdesk/freescout/wiki/Installation-Guide), the "one-click install" or the "interactive installation bash-script", and you are viewing this page using a macOS or Ubuntu system.

Other installations are possible, but not supported here.

1. Download the [latest release of FreeScout Sidebar Webhook](https://github.com/fulldecent/freescout-sidebar-webhook/releases).
2. Unzip the file locally.
3. Copy the folder into your server using SFTP. (ℹ️ Folder is renamed in this process.)
   ```sh
   scp -r ~/Downloads/freescout-sidebar-webhook root@freescout.example.com:/var/www/html/Modules/SidebarWebhook/
   ```
4. SSH into the server and update permissions on that folder. 
   ```sh
   chown -R www-data:www-data /var/www/html/Modules/SidebarWebhook/
   ```
5. Access your admin modules page like https://freescout.example.com/modules/list.
6. Find **Sidebar Webhook** and click ACTIVATE.
7. Configure the webhook URL in the mailbox settings. The webhook secret is optional and will be sent as part of the payload if set.
8. After everything works, purchase a license code by sending USD 10 at https://www.paypal.com/paypalme/fulldecent/10usd

## Your webhook server

Your webhook server will receive a POST request with this kind of JSON body:
```json
{
    "customerId": 123,
    "conversationSubject": "Testing this sidebar",
    "conversationType": "Phone",
    "conversationId": 456,
    "conversationNumber": 1001,
    "customerEmail": "hello@example.com",
    "customerEmails": [
      "hello@example.com",
      "welcome@example.com"
    ],
    "customerPhones": [{
	    "n": "",
      "type": 1,
      "value": ""
    }],
    "mailboxId": 1,
    "secret": "0C7DA918-E72C-47B2-923B-0C5BB6A6104E",
    "cspNonce": "h1xKF8N5n3ajCg3QG43Gz0UWm"
}
```

Your webhook server shall respond with content to be injected into the sidebar. The document should be a complete, well-formed HTML document like so:

```html
<html>
    <body>
        <h1>Hello world</h1>
    </body>
</html>
```

You can optionally set a title in the document and it will be used as the panel title in the sidebar:

```html
<html>
    <head>
        <title>My panel title</title>
    </head>
    <body>
        <h1>Hello world</h1>
    </body>
</html>
```
Setting CORS headers is not required, as the document is requested by the FreeScout server (not by the user's browser).

## Scripts

FreeScout's Content-Security-Policy allows scripts loaded from the FreeScout origin. Inline scripts, and scripts from other origins, run only when the `<script>` element carries the nonce for that page. The nonce changes on every full page load. It is not available from `Helper::cspNonce()` during the sidebar Ajax request: that call creates a new nonce for the Ajax request, which does not match the conversation page.

This module reads the nonce from the page's CSP meta tag and sends it as `cspNonce`. Put that value on every script you return:

```php
<?php
$payload = json_decode(file_get_contents('php://input'), true) ?: [];
$nonce = $payload['cspNonce'] ?? '';
if (!is_string($nonce) || !preg_match('/\A[A-Za-z0-9]{1,128}\z/', $nonce)) {
    $nonce = '';
}
header('Content-Type: text/html; charset=UTF-8');
?>
<html>
    <head>
        <title>Orders</title>
    </head>
    <body>
        <p id="swh-orders">Loading orders…</p>
        <script type="module" nonce="<?php echo htmlspecialchars($nonce, ENT_QUOTES, 'UTF-8'); ?>">
            document.getElementById('swh-orders').textContent = 'Script ran';
        </script>
    </body>
</html>
```

`cspNonce` stays the same if the agent only clicks Refresh. Read it from the current POST body. Do not cache it for a later page view.

The sidebar inserts the returned HTML as a string. `onclick` and other event-handler attributes stay blocked by the policy. Scripts from the webhook run in the agent's browser, as the logged-in user, so point the webhook URL only at a server you trust.

## Project scope

Our goal is to have a very simple module to allow vast extensibility in the conversation sidebar.

Anything that makes it simpler (removes unneded code) or more extensible for most people (adding a couple post parameters in `boot()`) will be a welcome improvement.

## Troubleshooting

Hints

* >  Class "Modules\SidebarWebhook\Providers\SidebarWebhookServiceProvider" not found

  Did you rename the folder as per step 3?

If something is not working, please try these steps so we can see what's wrong.

1. Update FreeScout to the latest version (even if the new version doesn't have any relevant changes, the process of updating can sometimes fix problems that would prevent freescout-sidebar-webhook from running).
2. Use `chown -r` to ensure the module has the same owner/permissions as other files in your FreeScout installation.
3. Try to disable and reenable freescout-sidebare-webhook from your system/modules page.
4. To confirm the module file is actually activated and readable you might add a line like this above the `private const MODULE_NAME` line. The code to add is: `file_put_contents("/tmp/sidebartmp", "is running");` And then you can confirm it is running by seeing if that file is created when you load the page.
5. Next check for system logs. It will be helpful to note any warnings, errors or notices as they may instruct where the problem is coming from.
6. Check your PHP version, is it a version supported by FreeScout?

After you have checked all these things, please create an issue and detail how you tried each of these steps.

## Inspiration

* This project was inspired by [Sidebar API](https://github.com/scout-devs/SidebarApi).
