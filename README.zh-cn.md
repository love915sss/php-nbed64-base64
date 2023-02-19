# Nbed64.PHP


## 下列为支持阅读的其它语言：

+ [English] , [简体中文] , [繁體中文] , [日本語] , [한국어] , [Polski] , [Français] , [Español] , [Português] 

## 温馨提示：

+  *自述文件支持以下语种，其中，中文为作者的母语，因此表达分歧最少！如果您有能力阅读中文，请尽量阅读中文版的 README.md。谢谢！！！* 

[English]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.md
[简体中文]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.zh-cn.md
[繁體中文]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.zh-tw.md
[日本語]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.ja.md
[한국어]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.kr.md
[Polski]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.pl.md
[Français]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.fr.md
[Español]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.es.md
[Português]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.pt.md



# Nbed64加解密方案的主要能力

### Nbed64共提供了12个API，分为3组，每组4个API。分别为：

1. 动态加解密API组
	* [nbed64StringEncryptEx()]  动态加密字符串，数据不变，密钥不变，**但加密结果不重复，次次都变**
	* [nbed64StringDecryptEx()]  动态解密字符串，与 nbed64StringEncryptEx()是一对
	* [nbed64BinaryEncryptEx()]  动态加密二进制，数据不变，密钥不变，**但加密结果不重复，次次都变**
	* [nbed64BinaryDecryptEx()]  动态解密二进制，与 nbed64BinaryEncryptEx()是一对

2. 对称加解密API组
	* [nbed64StringEncrypt()]  对称加密字符串，数据不变，密钥不变，**加密结果也不变，固定不变的**
	* [nbed64StringDecrypt()]  对称解密字符串，与 nbed64StringEncrypt()是一对
	* [nbed64BinaryEncrypt()]  对称加密二进制，数据不变，密钥不变，**加密结果也不变，固定不变的**
	* [nbed64BinaryDecrypt()]  对称解密二进制，与 nbed64BinaryEncrypt()是一对

3. 标准Base64编解码API组
	* [nbed64StringEncode()]  标准的Base64编码，用于编码字符串，支持RFC4648安全规范
	* [nbed64StringDecode()]  标准的Base64解码，用于解码字符串，支持RFC4648安全规范
	* [nbed64BinaryEncode()]  标准的Base64编码，用于编码二进制，支持RFC4648安全规范
	* [nbed64BinaryDecode()]  标准的Base64解码，用于解码二进制，支持RFC4648安全规范

*备注：动态加密是(传统)对称加密的升级版，但本质上，它还是对称加密，但它比传统的对称加密更加安全可靠。如果您对此有研究兴趣，请您移步 *[动态加密的作用和原理]*了解更多详情。*

[nbed64StringEncryptEx()]: https://github.com/love915sss/php-nbed64-base64/#01-nbed64stringencryptex
[nbed64StringDecryptEx()]: https://github.com/love915sss/php-nbed64-base64/#02-nbed64StringDecryptEx
[nbed64BinaryEncryptEx()]: https://github.com/love915sss/php-nbed64-base64/#03-nbed64BinaryEncryptEx
[nbed64BinaryDecryptEx()]: https://github.com/love915sss/php-nbed64-base64/#04-nbed64BinaryDecryptEx
[nbed64StringEncrypt()]: https://github.com/love915sss/php-nbed64-base64/#05-nbed64StringEncrypt
[nbed64StringDecrypt()]: https://github.com/love915sss/php-nbed64-base64/#06-nbed64StringDecrypt
[nbed64BinaryEncrypt()]: https://github.com/love915sss/php-nbed64-base64/#07-nbed64BinaryEncrypt
[nbed64BinaryDecrypt()]: https://github.com/love915sss/php-nbed64-base64/#08-nbed64BinaryDecrypt
[nbed64StringEncode()]: https://github.com/love915sss/php-nbed64-base64/#09-nbed64StringEncode
[nbed64StringDecode()]: https://github.com/love915sss/php-nbed64-base64/#10-nbed64StringDecode
[nbed64BinaryEncode()]: https://github.com/love915sss/php-nbed64-base64/#11-nbed64BinaryEncode
[nbed64BinaryDecode()]: https://github.com/love915sss/php-nbed64-base64/#12-nbed64BinaryDecode
[动态加密的作用和原理]: https://github.com/love915sss/php-nbed64-base64/#动态加密的作用和原理



# Nbed64的设计初衷与特性

1. 在Nbed64问世之前，市面上早就不缺对称加密算法，像AES、DES、TDEA、RC4、RC5等...已如雷贯耳，那么设计Nbed64的意义在哪里？答案是：可读性 + 通用性 + 轻量级。传统加密算法均有一个共性：主要服务于二进制数据安全。加密的结果不能字符化，而不能字符化就意味着：没有输入性，也没有可读性，不方便打印，不方便调试，等等...这是不利于现代可视化交互的，尤其像JS、PHP等脚本语言操作二进制很不方便！在WEB应用中，以及基于WEB的APP中，传统加密都很不方便作数据交互。怎么办呢，人们通常有两个选择：1. 转换成十六进制文本，2. 转换成Base64 文本。于是，网上到处都是AES、DES转Base64的帖子。您看，转了一圈，问题又回来了----那么我们为什么不直接在Base64编码的基础上来实现加密呢？为什么要脱裤子放屁呢？！于是，打造一套轻量的、通用的、可读的、开箱即用的加密方案，这，就是作者设计Nbed64的初衷！

2. Nbed64是一套[多语言] + [跨平台]的加解密库，Nbed64现已开源的语种有：GO版、C#版、C/C++版、Java版、Python版、JavaScript版、PHP版、E版，以及其它即将问世的语种版。这意味着，在所有主流编程语言中，但凡使用Nbed64加解密的数据，都均可无障碍交互。对不同语言的开发者，Nbed64的函数名，参数数量，参数位置， 执行结果，都是一致的、统一的。换句话说：使用Nbed64，前后端的开发者不论使用什么语言，对结果的认识是统一的，是没有分歧的，是可以无障碍交互数据的。

3. Nbed64是Network Bridge Encrypt Decrypt Base64的缩写，它是一套通用的、开源的、跨语言的、跨平台的卓越加密方案库。这套库的算法最早由合肥网桥网络科技的CEO设计于2014年，当初仅有C++一个版本，随后在其公司的生产环境中不断扩充和迭代，发展成了今天的多语种版。因此nb指的就是网桥科技，ed指的是加密和解密，64指的是该算法基于Base64编码框架。请不要误以为nbed意指'非对称的...'，这样理解是错误的！强调一下， Nbed64是一套对称的加密方案，以及升级版的对称加密方案，人们很喜欢称之为：动态加密方案！

4. Nbed64对字符集的编码由内部算法实现，如：UTF-8，UTF-16，GBK等。它不依赖运行平台的API，不依赖运行环境的API。这意味着：在Windows、Linux、Unix、Mac、Android、Ios等不同的平台中运行的结果是一致的，安全的，稳定的。使用者使用跨平台语言开发时不必关心各系统平台之间的差异，也不必关心各种编码API在不同系统平台上使用的差异。开箱即用，编码问题与您无关。

5. Nbed64解密字符串时，会自动转换为当前语言的默认编码。如JavaScript环境中，被解密的字符串会自动转换为UTF-16，因为JavaScript的默认编码就是UTF-16，也只有UTF-16才不会乱码。强调一下，这里"自动"所指的意思是：不论原内容是UTF-8编码也好，是GBK编码也罢，只要在JS里解密字符串就必然是UTF-16，在C/C++里解密就必然是UTF-8。这样的设计很方便也很重要，众所周知，不同编程语言的默认编码是不同的，这意味着跨语言数据交互是需要彼此转换编码的，当彼此的默认编码不同时，开发者需要知已知彼才能转换编码，这是繁琐头疼的过程。而Nbed64解决了这样的尴尬，它在解密时扮演着自动翻译者的工作。这让开发者之间可以尽情的交互数据，而不必分散精力来处理彼此的编码问题。

6. Nbed64为何选择Base64作为加密框架呢？因为，二进制转成字符集的常用方案有两种：十六进制文本 和 Base64文本。其中十六进制需要两个字符表示一个字节，因此，十六进制占用内存的尺寸为：X * 2，所以，会有1倍的空间浪费。而Base64则用4个字符表示3个字节，因此，Base64占用内存的尺寸为：X / 3 * 4，所以，只有3分之1的空间浪费。在网络当道的今天，Nbed64只能选择更节约的Base64编码框架。同样能满足需求，当然要保持节约精神。

7. Nbed64的算法虽然基于Base64编码框架，但算法经过大量优化，性能远高于传统的Base64算法。作者曾在多平台下作过对比，各以10MB测试数据为例，Nbed64解密数据平均比传统的base64解码数据快100倍以上！主要原因是：传统的Base64解码时，通过遍历查找Base64映射表中的字符串来寻址，而Nbed64直接通过计算推导来寻址，因此少了一层for()循环，再加上其它各种优化，性能便有了极大的提升。经过压力测试，即使在移动浏览器中使用JavaScript编码512MB的数据也迅捷快速、毫无压力，其它语言和平台的性能自不必多说了。

8. Nbed64使用Apache License 2.0 开源协议----Apache License 2.0 是当今最友好的开源协议之一。这意味着：任何个人、组织、企业、机构都可以随意修改、转发、共享、商用 Nbed64加密库...



# 相关链接

### Nbed64 在GitHub上开源的其它语种版本
+ [C-Nbed64] 作者用 C/C++ 语言编写的版本
+ [Go-Nbed64] 作者用 Golang 语言编写的版本
+ [JS-Nbed64] 作者用 JavaScript 语言编写的版本
+ [VB-Nbed64] 作者用 Visual Basic 语言编写的版本
+ [CS-Nbed64] 作者用 C Sharp |  C# 语言编写的版本
+ [PHP-Nbed64] 作者用 PHP 语言编写的版本
+ [JAVA-Nbed64] 作者用 JAVA 语言编写的版本
+ [Python-Nbed64] 作者用 Python 语言编写的版本

*备注：由于编写Demo和README需要大量的时间和精力，因此作者无法在短期内将以上所有的语种版本全部Push。不过别担心，作者不会放松进度和改变计划，弥补空缺只是时间问题....*

[c-Nbed64]: https://github.com/love915sss/js-nbed64-base64/
[Go-Nbed64]: https://github.com/love915sss/Go-Nbed64-base64/
[JS-Nbed64]: https://github.com/love915sss/js-nbed64-base64/
[VB-Nbed64]: https://github.com/love915sss/VB-Nbed64-base64/
[CS-Nbed64]: https://github.com/love915sss/CS-Nbed64-base64/
[PHP-Nbed64]: https://github.com/love915sss/PHP-Nbed64-base64/
[JAVA-Nbed64]: https://github.com/love915sss/JAVA-Nbed64-base64/
[Python-Nbed64]: https://github.com/love915sss/Python-Nbed64-base64/



## 环境要求

* PHP: 7.1+/8.0+

## 安装

``` bash
$ composer require nbed64
```



# 函数原型 && DEMO

## 01. nbed64StringEncryptEx

### nbed64StringEncryptEx() Be used as dynamic encryption string, The data remains unchanged, The key remains unchanged, **But the encryption result is not repeated**

+ 函数原型：

```php
/**
 * Base64对字符串加密的升级版，简称：字符串动态加密（ 本函数与 nbed64StringDecryptEx()为一对 ）
 * @param str {string} 原数据。
 * @param key {string} 密钥。理论上密钥的长度与逆向的难度成正比关系。
 * @param isUtf8 {boolean} 是否采用UTF-8编码格式。默认为：true。若设置为false，则使用UTF-16编码。
 * 注意：此处指的是加密前的编码，而非加密后的base64编码，base64是无须编码的。换句话来说，本参数指的是解密后的字符串编码。
 * JS的默认编码为UTF-16，但UTF-16并不友好，很多编程语言和服务端环境都不支持UTF-16。
 * @param maskNumber {number} 掩码的数量。缺省为：32，范围：32 - 65535。当值小于32时为32，大于65535时为65535。
 * @return 加密结果 {string} Base64格式的字符串
 */
function nbed64StringEncryptEx($str, $key, $isUtf8 = true, $maskNumber = 32) { ... }
```

+ DEMO：

```php
	// Statement: The result of dynamic encryption will be different every time
	$isUtf8 = true;
	$key = 'Key1234567890++';
	$text = 'This is the string content that needs to be encrypted ...';
	$base64 = nbed64StringEncryptEx($text, $key, $isUtf8);
	echo ('Results of dynamic encryption : ' . $base64);
	// echo  -> Results of dynamic encryption : a0uJd6EATJExVa2ewU366YsGEUEFIIw9_O8lXfA0ty5FGTm6emBFcejt2Jn5LXBAMFkpWcXB8Tk4mYkIrei5eej9uVmpqbi9iMkN-dntuekZyNlp-bmpvfXV1d
	echo ('Retry Comparison -------------: ' . nbed64StringEncryptEx($text, $key, $isUtf8));
	// echo  -> Retry Comparison -------------: a0vhNploZYEChcZ1JCQV7xyAJlDezRAt8ys_P2_BKSxRMjq5eWjN-Wjt2JV1ofDQoMkpWc35yQk4mYkYvfCxceCl4QGhobBFcDkN-dGl8akZyNDgcDmJnd1dXV
	$textDec = nbed64StringDecryptEx($base64, $key, $isUtf8);
	echo ('Results of dynamic decryption :' + $textDec);
	// echo  -> Results of dynamic decryption :This is the string content that needs to be encrypted ...
```



## 02. nbed64StringDecryptEx

### nbed64StringDecryptEx() Be used as Dynamic decryption string （ This function And nbed64StringEncryptEx() It's a pair )

+ 函数原型：

```php
/**
 * Base64解密成字符串的升级版，简称：字符串动态解密（ 本函数与 nbed64StringEncryptEx()为一对 ）
 * @param {string} base64str base64格式的加密字符串
 * @param {string} key 密钥。本参数请保持与加密时的设置完全一致。
 * @param {boolean} isUtf8 是否采用UTF-8编码格式。本参数请保持与加密时的设置完全一致。（注意：这里指的是加密前的编码，并非解密后的编码）
 * @return 解密结果 {string } 注意：结果为UTF-8编码格式。为方便使用，PHP语言统一为UTF-8编码。换句话说，在PHP中，本函数返回的必定是UTF-8。
 */
function nbed64StringDecryptEx($base64str, $key, $isUtf8 = true) { ... }
```

+ DEMO：

```php
	// Statement: The result of dynamic encryption will be different every time
	$isUtf8 = true;
	$key = 'Key1234567890++';
	$text = 'This is the string content that needs to be encrypted ...';
	$base64 = nbed64StringEncryptEx($text, $key, $isUtf8);
	echo ('Results of dynamic encryption : ' . $base64);
	// echo  -> Results of dynamic encryption : a0uJd6EATJExVa2ewU366YsGEUEFIIw9_O8lXfA0ty5FGTm6emBFcejt2Jn5LXBAMFkpWcXB8Tk4mYkIrei5eej9uVmpqbi9iMkN-dntuekZyNlp-bmpvfXV1d
	echo ('Retry Comparison -------------: ' . nbed64StringEncryptEx($text, $key, $isUtf8));
	// echo  -> Retry Comparison -------------: a0vhNploZYEChcZ1JCQV7xyAJlDezRAt8ys_P2_BKSxRMjq5eWjN-Wjt2JV1ofDQoMkpWc35yQk4mYkYvfCxceCl4QGhobBFcDkN-dGl8akZyNDgcDmJnd1dXV
	$textDec = nbed64StringDecryptEx(base64, $key, $isUtf8);
	echo ('Results of dynamic decryption :' + $textDec);
	// echo  -> Results of dynamic decryption :This is the string content that needs to be encrypted ...
```



## 03. nbed64BinaryEncryptEx

### nbed64BinaryEncryptEx() Be used as Dynamically encrypt binary, The data remains unchanged, The key remains unchanged, **But the encryption result is not repeated**

+ 函数原型：

```php
/**
 * Base64对二进制数据加密的升级版，简称：二进制动态加密（ 本函数与 nbed64BinaryDecryptEx()为一对 ）
 * @param byteArr {ByteArray} 原数据。二进制字节数组，如：视频、音频、图片、文件等。
 * @param key {string} 密钥。理论上密钥的长度与逆向的难度成正比关系。
 * @param maskNumber {number} 掩码的数量。缺省为：32，范围：32 - 65535。当值小于32时为32，大于65535时为65535。
 * @return 加密结果 {string} Base64格式的字符串
 */
function nbed64BinaryEncryptEx(byteArr, $key, $maskNumber = 32) { ... }
```

+ DEMO：

```php
	// Statement: The result of dynamic encryption will be different every time
	$key = 'Key1234567890++';
	$mp4 = array(255, 254, 253, 252, 251, 250, 249, 248, 247, 246);
	$base64 = nbed64BinaryEncryptEx($mp4, $key);
	echo ('Results of dynamic encryption : ' . $base64);
	// echo  -> Results of dynamic encryption : a0svUqijsI2imowGM0cawSzgBL3EKb715b0LfA7sn76QlDEBESAwQFBgcIAf
	echo ('Retry Comparison ------------ : ' . nbed64BinaryEncryptEx($mp4, $key));
	// echo  -> Retry Comparison ------------ : a0u9gfcjNO5e5y1_ym6PnddhSdyhL8j75Ndsev0I9ZVCUDAAECERYXAgMMgX
	$textDec = nbed64BinaryDecryptEx($base64, $key);
	echo ('Results of dynamic decryption :' + $textDec);
	// echo  -> Results of dynamic decryption :255,254,253,252,251,250,249,248,247,246
```



## 04. nbed64BinaryDecryptEx

### nbed64BinaryDecryptEx() Be used as Dynamically decrypt binary, And nbed64BinaryEncryptEx() It's a pair

+ 函数原型：

```php
/**
 * Base64解密成二进制数据的升级版，简称：二进制动态解密（ 本函数与 nbed64BinaryEncryptEx()为一对 ）
 * @param base64str {string} base64格式的加密字符串
 * @param key {string} 密钥。本参数请保持与加密时的设置完全一致。
 * @return 解密结果 {ByteArray} 为字节数组（也就是二进制数据流）
 */
function nbed64BinaryDecryptEx($base64str, $key){ ... }
```

+ DEMO：

```php
	// Statement: The result of dynamic encryption will be different every time
	$key = 'Key1234567890++';
	$mp4 = array(255, 254, 253, 252, 251, 250, 249, 248, 247, 246);;
	$base64 = nbed64BinaryEncryptEx($mp4, $key);
	echo ('Results of dynamic encryption : ' . $base64);
	// echo  -> Results of dynamic encryption : a0svUqijsI2imowGM0cawSzgBL3EKb715b0LfA7sn76QlDEBESAwQFBgcIAf
	echo ('Retry Comparison ------------ : ' . nbed64BinaryEncryptEx($mp4, $key));
	// echo  -> Retry Comparison ------------ : a0u9gfcjNO5e5y1_ym6PnddhSdyhL8j75Ndsev0I9ZVCUDAAECERYXAgMMgX
	$textDec = nbed64BinaryDecryptEx($base64, $key);
	echo ('Results of dynamic decryption :' + $textDec);
	// echo  -> Results of dynamic decryption :255,254,253,252,251,250,249,248,247,246
```



## 05. nbed64StringEncrypt

### nbed64StringEncrypt() Be used as Symmetrical encryption string, The data remains unchanged, The key remains unchanged, **The encryption result remains the same, changeless**

+ 函数原型：

```php
/**
 * Base64对字符串加密（ 本函数与 nbed64StringDecrypt()为一对 ）
 * @param str {string} 原数据。
 * @param key {string} 密钥。理论上密钥的长度与逆向的难度成正比关系。
 * @param isUtf8 {boolean} 是否采用UTF-8编码格式。默认为：true。若设置为false，则使用UTF-16编码。
 * 注意：此处指的是加密前的编码，而非加密后的base64编码，base64是无须编码的。换句话来说，本参数指的是解密后的字符串编码。
 * JS的默认编码为UTF-16，但UTF-16并不友好，很多编程语言和服务端环境都不支持UTF-16。
 * @param isRFC4648 {boolean} 是否采用RFC4648编码映射规范，默认为：true。采用RFC4648规范编码的Base64符合URL安全，可用于HTTP协议与Ajax请求。
 * @return 加密结果 {string} Base64格式的字符串
 */
function nbed64StringEncrypt($str, $key, $isUtf8 = true, $isRFC4648 = true){ ... }
```

+ DEMO：

```php
	// Statement: The result of symmetric encryption is the same every time and is fixed
	$isUtf8 = true;
	$isRFC4648 = true;
	$key = 'Key1234567890++';
	$text = 'This is the string content that needs to be encrypted ...';
	$base64 = nbed64StringEncrypt($text, $key, $isUtf8, $isRFC4648);
	echo ('Results of symmetric encryption : ' . $base64);
	// echo  -> Results of symmetric encryption : HyMiFkUMClkNWVQRQUZAWl1UFFdbW0FQWEIWQ19WTBhWXFxdQxBERAtJTgtOJSg5HBURHB1ZHx8f
	echo ('Retry Comparison -------------- : ' . nbed64StringEncrypt($text, $key, $isUtf8, $isRFC4648));
	// echo  -> Retry Comparison -------------- : HyMiFkUMClkNWVQRQUZAWl1UFFdbW0FQWEIWQ19WTBhWXFxdQxBERAtJTgtOJSg5HBURHB1ZHx8f
	$textDec = nbed64StringDecrypt($base64, $key, $isUtf8);
	echo ('Results of symmetric decryption : ' . $textDec);
	// echo  -> Results of symmetric decryption : This is the string content that needs to be encrypted ...
```



## 06. nbed64StringDecrypt

### nbed64StringDecrypt() Be used as Symmetrical decryption string, And nbed64StringEncrypt() It's a pair

+ 函数原型：

```php
/**
 * Base64解密成字符串（ 本函数与 nbed64StringEncrypt()为一对 ）
 * @param base64str {string} base64格式的加密字符串
 * @param key {string} 密钥。本参数请保持与加密时的设置完全一致。
 * @param isUtf8 {boolean} 是否采用UTF-8编码格式。本参数请保持与加密时的设置完全一致。（注意：这里指的是加密前的编码，并非解密后的编码）
 * @return 解密结果 {string } 注意：结果为UTF-8编码格式。为方便使用，PHP语言统一为UTF-8编码。换句话说，在PHP中，本函数返回的必定是UTF-8。
 */
function nbed64StringDecrypt($base64str, $key, $isUtf8 = true){ ... }
```

+ DEMO：

```php
	// Statement: The result of symmetric encryption is the same every time and is fixed
	$isUtf8 = true;
	$isRFC4648 = true;
	$key = 'Key1234567890++';
	$text = 'This is the string content that needs to be encrypted ...';
	$base64 = nbed64StringEncrypt($text, $key, $isUtf8, $isRFC4648);
	echo ('Results of symmetric encryption : ' . $base64);
	// echo  -> Results of symmetric encryption : HyMiFkUMClkNWVQRQUZAWl1UFFdbW0FQWEIWQ19WTBhWXFxdQxBERAtJTgtOJSg5HBURHB1ZHx8f
	echo ('Retry Comparison -------------- : ' . nbed64StringEncrypt($text, $key, $isUtf8, $isRFC4648));
	// echo  -> Retry Comparison -------------- : HyMiFkUMClkNWVQRQUZAWl1UFFdbW0FQWEIWQ19WTBhWXFxdQxBERAtJTgtOJSg5HBURHB1ZHx8f
	$textDec = nbed64StringDecrypt($base64, $key, $isUtf8);
	echo ('Results of symmetric decryption : ' . $textDec);
	// echo  -> Results of symmetric decryption : This is the string content that needs to be encrypted ...
```



## 07 nbed64BinaryEncrypt

### nbed64BinaryEncrypt() Be used as Symmetrically encrypted binary, The data remains unchanged, The key remains unchanged, **The encryption result remains the same, changeless**

+ 函数原型：

```php
/**
 * Base64对二进制数据加密（ 本函数与 nbed64BinaryDecrypt()为一对 ）
 * @param byteArr {byteArray} 原数据。二进制字节数组，如：视频、音频、图片、文件等。
 * @param key {string} 密钥。理论上密钥的长度与逆向的难度成正比关系。
 * @param isRFC4648 {boolean} 是否采用isRFC4648编码映射规范，默认为：true。采用isRFC4648规范编码的Base64符合URL安全，可用于HTTP协议与Ajax请求。
 * @return 加密结果 {string} Base64格式的字符串
 */
function nbed64BinaryEncrypt($byteArr, $key, $isRFC4648 = true){ ... }
```

+ DEMO：

```php
	// Statement: The result of symmetric encryption is the same every time and is fixed
	$isRFC4648 = true;
	$key = 'Key1234567890++';
	$mp3 = array([155, 154, 153, 152, 151, 150, 149, 148, 147, 146]);;
	$base64 = nbed64BinaryEncrypt(mp3, $key, $isRFC4648);
	echo ('Results of symmetric encryption : ' . $base64);
	// echo  -> Results of symmetric encryption : 0NHS_fLz7O3qoz
	echo ('Retry Comparison -------------- : ' . nbed64BinaryEncrypt(mp3, $key, $isRFC4648));
	// echo  -> Retry Comparison -------------- : 0NHS_fLz7O3qoz
	$textDec = nbed64BinaryDecrypt($base64, $key);
	echo ('Results of symmetric decryption : ' . $textDec);
	// echo  -> Results of symmetric decryption : 155,154,153,152,151,150,149,148,147,146
```



## 08. nbed64BinaryDecrypt

### nbed64BinaryDecrypt() Be used as Symmetrically decrypt binary, And nbed64BinaryEncrypt() It's a pair

+ 函数原型：

```php
/**
 * Base64解密成二进制数据（ 本函数与 nbed64BinaryEncrypt()为一对 ）
 * @param base64str {string} base64格式的加密字符串
 * @param key {string} 密钥。本参数请保持与加密时的设置完全一致。
 * @return 解密结果 {ByteArray} 为字节数组（也就是二进制数据流）
 */
function nbed64BinaryDecrypt($base64str, $key){ ... }
```

+ DEMO：

```php
	// Statement: The result of symmetric encryption is the same every time and is fixed
	$isRFC4648 = true;
	$key = 'Key1234567890++';
	$mp3 = array([155, 154, 153, 152, 151, 150, 149, 148, 147, 146]);;
	$base64 = nbed64BinaryEncrypt(mp3, $key, $isRFC4648);
	echo ('Results of symmetric encryption : ' . $base64);
	// echo  -> Results of symmetric encryption : 0NHS_fLz7O3qoz
	echo ('Retry Comparison -------------- : ' . nbed64BinaryEncrypt(mp3, $key, $isRFC4648));
	// echo  -> Retry Comparison -------------- : 0NHS_fLz7O3qoz
	$textDec = nbed64BinaryDecrypt($base64, $key);
	echo ('Results of symmetric decryption : ' . $textDec);
	// echo  -> Results of symmetric decryption : 155,154,153,152,151,150,149,148,147,146
```



## 09. nbed64StringEncode

### nbed64StringEncode() Standard Base64 encoding, Used as encoding string, Support RFC4648 security specification

+ 函数原型：

```php
/**
 * Base64对字符串编码（ 注意：这是编码而非加密， 本函数与 nbed64StringDecode()为一对 ）
 * @param str {string} 原数据。
 * @param isUtf8 {boolean} 是否采用UTF-8编码格式。默认为：true。若设置为false，则使用UTF-16编码。
 * 注意：此处指的是编码前的编码，而非编码后的base64编码，base64是无须编码的。换句话来说，本参数指的是解码后的字符串编码。
 * JS的默认编码为UTF-16，但UTF-16并不友好，很多编程语言和服务端环境都不支持UTF-16。
 * @param isRFC4648 {boolean} 是否采用RFC4648编码映射规范，默认为：true。采用RFC4648规范编码的Base64符合URL安全，可用于HTTP协议与Ajax请求。
 * @return 编码结果 {string} 标准Base64格式的字符串
 */
function nbed64StringEncode($str, $isUtf8 = true, $isRFC4648 = true){ ... }
```

+ DEMO：

```php
	// Statement: Standard Base64 encoding, Support RFC4648 security specification
	$isUtf8 = true;
	$isRFC4648 = true;
	$text = 'This is the string content to be encoded--Base64...';
	$base64 = nbed64StringEncode($text, $isUtf8, $isRFC4648);
	echo ('Base64 encoded results : ' . $base64);
	// echo  -> Base64 encoded results : VGhpcyBpcyB0aGUgc3RyaW5nIGNvbnRlbnQgdG8gYmUgZW5jb2RlZC0tQmFzZTY0Li4u
	$textDec = nbed64StringDecode($base64, $isUtf8);
	echo ('Base64 decoding result : ' . $textDec);
	// echo  -> Base64 decoding result : This is the string content to be encoded--Base64...
```



## 10. nbed64StringDecode

### nbed64StringDecode() Standard Base64 decoding, Used as decoding string, Support RFC4648 security specification

+ 函数原型：

```php
/**
 * Base64解码成字符串（ 注意：这是解码而非解密， 本函数与 nbed64StringEncode()为一对 ）
 * @param base64str {string} base64格式编码的字符串
 * @param isUtf8 {boolean} 是否采用UTF-8编码格式。本参数请保持与编码时的设置完全一致。
 * @return 解码结果 {string } 注意：结果为UTF-16编码格式。为方便使用，解码结果会自动转换成当前程序语言的默认编码，以便开箱即用，省略二次编码。JS默认编码：UTF-16
 */
function nbed64StringDecode($base64str, $isUtf8 = true){ ... }
```

+ DEMO：

```php
	// Statement: Standard Base64 decode, But the performance of this algorithm is very high
	$isUtf8 = true;
	$isRFC4648 = true;
	$text = 'This is the string content to be encoded--Base64...';
	$base64 = nbed64StringEncode($text, $isUtf8, $isRFC4648);
	echo ('Base64 encoded results : ' . $base64);
	// echo  -> Base64 encoded results : VGhpcyBpcyB0aGUgc3RyaW5nIGNvbnRlbnQgdG8gYmUgZW5jb2RlZC0tQmFzZTY0Li4u
	$textDec = nbed64StringDecode($base64, $isUtf8);
	echo ('Base64 decoding result : ' . $textDec);
	// echo  -> Base64 decoding result : This is the string content to be encoded--Base64...
```



## 11. nbed64BinaryEncode

### nbed64BinaryEncode() Standard Base64 encoding, Used as encoding binary, Support RFC4648 security specification

+ 函数原型：

```php
/**
 * Base64对二进制数据编码（ 注意：这是编码而非加密， 本函数与 nbed64BinaryDecode()为一对 ）
 * @param byteArr {ByteArray} 原数据。二进制字节数组，如：视频、音频、图片、文件等。
 * @param isRFC4648 {boolean} 是否采用RFC4648编码映射规范，默认为：true。采用RFC4648规范编码的Base64符合URL安全，可用于HTTP协议与Ajax请求。
 * @return 编码结果 {string} 标准Base64格式的字符串
 */
function nbed64BinaryEncode(byteArr, $isRFC4648 = true){ ... }
```

+ DEMO：

```php
	// Statement: Standard Base64 encoding, Support RFC4648 security specification
	$isRFC4648 = true;
	$image = array(55, 54, 53, 52, 51, 50, 49, 48, 47, 46);;
	$base64 = nbed64BinaryEncode($image, $isRFC4648);
	echo ('Base64 encoded results : ' . $base64);
	// echo  -> Base64 encoded results : NzY1NDMyMTAvLg
	$textDec = nbed64BinaryDecode($base64);
	echo ('Base64 decoding result : ' . $textDec);
	// echo  -> Base64 decoding result : 55,54,53,52,51,50,49,48,47,46

```



## 12. nbed64BinaryDecode

### nbed64BinaryDecode() Standard Base64 decoding, Used as decode binary, Support RFC4648 security specification

+ 函数原型：

```php
/**
 * Base64解码成二进制数据（ 注意：这是解码而非解密， 本函数与 nbed64BinaryEncode()为一对 ）
 * @param base64str {string} base64格式编码的字符串
 * @return 解码结果 {ByteArray} 为字节数组（也就是二进制数据流）
 */
function nbed64BinaryDecode($base64str) { ... }
```

+ DEMO：

```php
	// Statement: Standard Base64 decode, But the performance of this algorithm is very high
	$isRFC4648 = true;
	$image = array(55, 54, 53, 52, 51, 50, 49, 48, 47, 46);;
	$base64 = nbed64BinaryEncode($image, $isRFC4648);
	echo ('Base64 encoded results : ' . $base64);
	// echo  -> Base64 encoded results : NzY1NDMyMTAvLg
	$textDec = nbed64BinaryDecode($base64);
	echo ('Base64 decoding result : ' . $textDec);
	// echo  -> Base64 decoding result : 55,54,53,52,51,50,49,48,47,46
```



# Extended knowledge reading

## Benefits and principles of dynamic encryption？

+ The purpose and significance of dynamic encryption is to: Protect the key and prevent reverse. Note that the essence of anti-inversion and asymmetric encryption algorithms mentioned here is different. Symmetric encryption usually has one flaw: Attackers can analyze packets through network, can calculate the original Key in reverse! In this way, Even if the key is distributed through asymmetric encryption on the server, Still meaningless. In short, as long as the attacker has an output window, no matter how well you protect the key, it is meaningless!

+ Generally, The purpose of asymmetric key transmission is to protect the process of key distribution by the server, However, the calculation result of Key cannot be protected, To protect the calculation result of the key and the key itself from being reversed, We need the mask algorithm to participate in it. Short name: Dynamic encryption!  This process is very abstract and inconvenient to describe in words, Let's look at the derivation directly: Assume that encryption is known as subtraction and decryption is known as addition ( Statement: This is not the point. It is interchangeable ), When the attacker enters' A ', The encryption process is: data=65, key=10，res=data-key,  Result=55, Attackers can get 55 when capturing packets, Know that 'A' is 65, Reverse calculation: key = 65 -55，So, Key=10 Is computable.This is the disadvantage of traditional symmetric encryption!

+ You may ask, If my data is very long, The key is also very long, Can attackers reverse? The answer is: Yes, the principle remains the same! Of course, the premise is that the attacker has an input window for packet capturing and analysis! You may also ask, if we change addition and subtraction to XOR, can we defense it? It's useless. The principle remains the same. The addition and subtraction method is used here for the convenience of deduction. OK, now let's see how the mask protects the key----Assuming the mask is 128, when the attacker enters' A ', The encryption process is: data=65, mask=128, key=10，res = data - (mask | key) ,  Result=183，The known bit or operation cannot be reversed, Can key be reversed now? The answer is: No! Of course not! 

+ After reading this, you may wonder why mask participation is also called dynamic encryption?Because the mask is usually a random array and is combined with the encrypted data, the careful reader may have understood-----The data and key remain the same, but the encrypted result changes every time, because the mask changes every time! Every time it changes, isn't it dynamic enough?!  Is it appropriate to describe it with dynamic?  In this way, not only the key is safe, but also the result is safer!You may also think that I will not transmit it, but write it directly in the APP, so that the attacker cannot catch the data packet? The answer is still: NO! first, Whether the key is distributed from the server, Or built-in in APP, If you are using non-dynamic encryption, And the attacker has an input window, So sorry, The attacker can directly obtain the encrypted result package and infer the key in reverse! Then, even with dynamic encryption, How high is the safety factor? What's the hardness of the shell you gave the APP cover?! At least in theory, there is no absolute hardness shell in the world!

+ In theory, there is no absolute security except quantum key distribution. The process of key distribution through the server must be transmitted through the network, which gives attackers the opportunity to capture packets. You may wonder whether it is safe for me to transmit the key after using asymmetric encryption? The answer is: NO! The attacker can cheat the server by forging the certificate by the agent, thus obtaining the key. 

+ Now, are you very confused?Since it is not safe to toss and turn, What's the point of our tossing and turning?! Well, this is a good question! The answer is simple: Everything is to increase the price and cost of attackers! Although no means is absolutely safe, there is no doubt that any means will increase the cost of deciphering! The superposition of protective measures will inevitably add to the cost of cracking. When the cost of the attacker's cracking is far greater than his profit, who will do the business at a loss? He is bound to give up! When cracking a system can make a profit of one million dollars, but the cost is 100 million dollars, Besides giving up, do you have any other choice?!!! Generally speaking, the cost of cracking is far greater than the cost of encryption, I think, This is the role and significance of encryption!



## What is RFC4648?
+ It is a set of specifications to ensure the security of URL encoding. As we all know, in Ajax requests, '/' And '+', None of them can appear in the GET parameter,Otherwise, URL encoding is required. In the URL specification, '/' represents the path, '+' represents the Spacebar, and '=' represents the analysis, However, these characters are included in the Base64 mapping table, The RFC4648 specification can solve this problem. How to solve it? Very simple: replace the original '+' with '-', and use '_' Replace the original '/', and the tail is not filled with '='

+ So everyone agreed to use this scheme internationally, which is the origin of Base64's RFC4648 encoding specification. Now, we have customized this standard. As long as we comply with this standard, the problem will be solved.



## In JavsScript, is the default encoding of String UTF-16 or UTF-8?
+ It is clearly stated in the ECMAScript specification and MDN: String is encoded for UTF-16, which is actually UTF-16. Therefore, any character stored in a String type occupies 2 bytes in memory, No matter English, Chinese, German, Japanese, Arabic Will occupy 2 bytes.

## Advantages and disadvantages of UTF-16
+ Advantages of UTF-16: In non-English scenarios, it saves memory than UTF-8. For example, in Chinese, UTF-8 requires at least 3 bytes, while UTF-16 only uses 2 bytes.

+ Disadvantages of UTF-16: it is not compatible with ASCII encoding specification, which is the emphasis! This means that the English characters must also use double bytes, and the high empty bits [0,0,0,0,0,0,0,0] must exist. At any time, the empty bytes in the high bits cannot be discarded due to the compression requirements!!! Otherwise, it will cause irreversible decoding error (highlight here, simply say: it will be garbled, and it is irreversible garbled)!

+ Note: Ajax requests will be automatically converted according to the definition of page encoding type, that is, the browser will automatically convert what encoding you define in HTML. So the string received by the backend will usually be UTF-8. However, it is important not to mistake the default encoding of string type for UTF-8! UTF-8 means 3 bytes for Chinese, and UTF-16 means only 2 bytes for Chinese.

+ Suggestion: UTF-16 can reduce network transmission costs, but only if you are familiar with UTF-16 coding and can use it freely, otherwise, please use simple and universal UTF-8. This knowledge point is mainly for developers who have secondary variant development of this source code. Users without secondary development requirements need not master it. thank you!!!



# About the author

### Author's blog

+  https://blog.csdn.net/qq_16661383?type=blog 

+ **If you have any suggestions or questions, you can leave a message here. thank you!!!**

### Author's QQ

+ **267949** 
+ Please explain your intention when adding, thank you!!!

### The author's prayer

+ May the world peace and technology have no borders...

