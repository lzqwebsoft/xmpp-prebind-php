XMPP Prebind for PHP
====================

This class is for [prebinding](http://metajack.im/2009/12/14/fastest-xmpp-sessions-with-http-prebinding/) a XMPP Session with PHP.

Usage
=====
* Clone the repo
* In your file where you want to do the prebinding:

```php
define('DS', DIRECTORY_SEPARATOR);

require_once 'lib' . DS .'XmppPrebind.php';
require_once 'lib' . DS . 'Log' . DS .'BaseLog.php';

$config = [
    'bosh_url'=> 'boshUri', // BOSH URL, eg: https://example.cn/http-bind/
    'domain'=>'jabberHost',  // XMPP server host, eg: example.cn
    'resource'=>'',      // Resource identifier, eg: web,pc,ios or worker, home
    'username'=>'',      // username
    'password'=>''       // password
];
$log = new BaseLog();

/**
 * Comment here for explanation of the options.
 *
 * Create a new XMPP Object with the required params
 * 
 * @param string $jabberHost Jabber Server Host
 * @param string $boshUri    Full URI to the http-bind
 * @param string $resource   Resource identifier
 * @param bool   $useSsl     Use SSL (not working yet, TODO)
 * @param BaseLog   $debug      Enable debug
 */
$xmppPrebind = new XmppPrebind($config['domain'], $config['bosh_url'], $config['resource'], false, $log);
$xmppPrebind->connect($config['username'], $config['password']);
$xmppPrebind->auth();
$sessionInfo = $xmppPrebind->getSessionInfo();   // array containing sid, rid and jid, like this: ['jid' => "test@example.cn/web",'sid' => "65rqhyrea8",'rid' => 1317120713]
```

* If you use [Candy](http://amiadogroup.github.com/candy), change the `Candy.Core.Connect()` line to the following:

```javascript
Candy.Core.attach('<?php echo $sessionInfo['jid'] ?>', '<?php echo $sessionInfo['sid'] ?>', '<?php echo $sessionInfo['rid'] ?>');
```

* You should now have a working prebinding with PHP

> Recommend [JSXC](https://www.jsxc.org/), A beautiful javascript XMPP client.

Debugging
=========
I had removed `FirePHP` class, because firebug was out, So you must implementent `lib\Log\BaseLog` class for debug info.

Other Languages
===============
There exist other projects for other languages to support a prebind. Go googling :)

Be aware
========
This class is in no way feature complete. There may also be bugs. I'd appreciate it if you contribute or submit bug reports.

Thanks.

Append to
=========
1. XMPP Over BOSH: https://xmpp.org/extensions/xep-0206.html
2. XMPP official document: https://xmpp.org/extensions