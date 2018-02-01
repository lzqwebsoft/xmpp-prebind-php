PHP XMPP协议预登录绑定
====================

这个类通过PHP实现了 [预登录绑定](http://metajack.im/2009/12/14/fastest-xmpp-sessions-with-http-prebinding/) XMPP会话.

用法
=====
* Clone 这个项目
* 在你将要预登录绑定XMPP的后台代码处:

```php
define('DS', DIRECTORY_SEPARATOR);

require_once 'lib' . DS .'XmppPrebind.php';
require_once 'lib' . DS . 'Log' . DS .'BaseLog.php';

$config = [
    'bosh_url'=> 'boshUri', // BOSH URL，例：https://example.cn/http-bind/
    'domain'=>'jabberHost',  // 你的XMPP后台HOST 例：example.cn
    'resource'=>'',        // 客户端资源标记,例：web、pc、android、iOS、worker等自定义
    'username'=>'',      // 帐户名
    'password'=>''       // 密码
];
$log = new BaseLog();

/**
 * 一些关于XMMP协议登录必须的配置参数
 *
 * @param string $jabberHost Jabber Server Host
 * @param string $boshUri    Full URI to the http-bind
 * @param string $resource   Resource identifier
 * @param bool   $useSsl     Use SSL (not working yet, TODO)
 * @param BaseLog  $log      Log object for debug
 */
$xmppPrebind = new XmppPrebind($config['domain'], $config['bosh_url'], $config['resource'], false, $log);
$xmppPrebind->connect($config['username'], $config['password']);
$xmppPrebind->auth();
$sessionInfo = $xmppPrebind->getSessionInfo();   // 返回一个数组，包含：['jid' => "test@example.cn/web",'sid' => "65rqhyrea8",'rid' => 1317120713]
```

> 这里说明一下jid、sid、rid：
> jid就相当于帐户名结合你的XMPP服务器拼接的全网唯一的身份标记ID，为什么叫jid，因为XMPP协议是由Jabber协议发展来的，所以沿用历史。
> sid就相当于XMPP服务器发行给XMPP客户端的会话session ID。
> rid是客户端的请求ID，是随机生成的一个整数，一次请求增加一位，用于保证请求的连续与安全，rid最大不超过9007199254740991即2的53次方减1，关于详情参见[RID的说明](https://xmpp.org/extensions/xep-0124.html#rids).


* 获取上面的三个值后，就可以使用Javascript等客户端直接登录XMPP服务器了。如果你使用 [Candy](http://amiadogroup.github.com/candy)（javascript XMPP客户端）, 可以参照如下行，改变 `Candy.Core.Connect()` 代码:

```javascript
Candy.Core.attach('<?php echo $sessionInfo['jid'] ?>', '<?php echo $sessionInfo['sid'] ?>', '<?php echo $sessionInfo['rid'] ?>');
```

* 以上你就通过PHP实现了XMPP的预登录绑定，并且与javascript客户端实现完美整合。

> 关于Javascript的XMPP客户端推荐使用[JSXC](https://www.jsxc.org/)，他的用法参见[https://www.jsxc.org/example/](https://www.jsxc.org/example/).

调试
=========
这里移出了原作者项目中使用的FirePHP（该插件输出的日志将被反应在Firebug上，但Firebug现在己经不流行了），你可以通过继承`lib\Log\BaseLog`类来实现自定义日志的显示

其它编程语言
===============
网络上存在使用其它编程语言实现XMPP协议的预登录，请GOOGLE :)

反馈
========
这个类还有一些其他的功能未完成，同时这里可能还有一些BUG，如果你可以贡献或提交BUG报告，我将为此感激.

谢谢.

中文附加
=========
1. XMPP的BOSH登录协议说明：https://xmpp.org/extensions/xep-0206.html
2. XMPP协议官方文档：https://xmpp.org/extensions/，中文翻译计划：http://wiki.jabbercn.org
3. 一个JAVA版XMPP协议的登录实现比较好的说明博客：http://www.jade-dungeon.net/study/wiki/wiki_html/xmpp.html