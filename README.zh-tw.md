# Nbed64.PHP


## 下列為支持閱讀的其它語言：

+ [English] , [简体中文] , [繁體中文] , [日本語] , [한국어] , [Polski] , [Français] , [Español] , [Português] 

## 溫馨提示：

+  *自述文件支持以下語種，其中，中文為作者的母語，因此表達分歧最少！如果您有能力閱讀中文，請盡量閱讀中文版的 README.md。謝謝！！！* 

[English]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.md
[簡體中文]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.zh-cn.md
[繁體中文]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.zh-tw.md
[日本語]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.ja.md
[한국어]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.kr.md
[Polski]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.pl.md
[Français]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.fr.md
[Español]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.es.md
[Português]: https://github.com/love915sss/php-nbed64-base64/blob/master/README.pt.md



# Nbed64加解密方案的主要能力

### Nbed64共提供了12個API，分為3組，每組4個API。分別為：

1. 動態加解密API組
	* [nbed64StringEncryptEx()]  動態加密字符串，數據不變，密鑰不變，**但加密結果不重復，次次都變**
	* [nbed64StringDecryptEx()]  動態解密字符串，與 nbed64StringEncryptEx()是一對
	* [nbed64BinaryEncryptEx()]  動態加密二進製，數據不變，密鑰不變，**但加密結果不重復，次次都變**
	* [nbed64BinaryDecryptEx()]  動態解密二進製，與 nbed64BinaryEncryptEx()是一對

2. 對稱加解密API組
	* [nbed64StringEncrypt()]  對稱加密字符串，數據不變，密鑰不變，**加密結果也不變，固定不變的**
	* [nbed64StringDecrypt()]  對稱解密字符串，與 nbed64StringEncrypt()是一對
	* [nbed64BinaryEncrypt()]  對稱加密二進製，數據不變，密鑰不變，**加密結果也不變，固定不變的**
	* [nbed64BinaryDecrypt()]  對稱解密二進製，與 nbed64BinaryEncrypt()是一對

3. 標準Base64編解碼API組
	* [nbed64StringEncode()]  標準的Base64編碼，用於編碼字符串，支持RFC4648安全規範
	* [nbed64StringDecode()]  標準的Base64解碼，用於解碼字符串，支持RFC4648安全規範
	* [nbed64BinaryEncode()]  標準的Base64編碼，用於編碼二進製，支持RFC4648安全規範
	* [nbed64BinaryDecode()]  標準的Base64解碼，用於解碼二進製，支持RFC4648安全規範

*備註：動態加密是(傳統)對稱加密的升級版，但本質上，它還是對稱加密，但它比傳統的對稱加密更加安全可靠。如果您對此有研究興趣，請您移步 *[動態加密的作用和原理]*了解更多詳情。*

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
[動態加密的作用和原理]: https://github.com/love915sss/php-nbed64-base64/#動態加密的作用和原理



# Nbed64的設計初衷與特性

1. 在Nbed64問世之前，市面上早就不缺對稱加密算法，像AES、DES、TDEA、RC4、RC5等...已如雷貫耳，那麽設計Nbed64的意義在哪裏？答案是：可讀性 + 通用性 + 輕量級。傳統加密算法均有一個共性：主要服務於二進製數據安全。加密的結果不能字符化，而不能字符化就意味著：沒有輸入性，也沒有可讀性，不方便打印，不方便調試，等等...這是不利於現代可視化交互的，尤其像JS、PHP等腳本語言操作二進製很不方便！在WEB應用中，以及基於WEB的APP中，傳統加密都很不方便作數據交互。怎麽辦呢，人們通常有兩個選擇：1. 轉換成十六進製文本，2. 轉換成Base64 文本。於是，網上到處都是AES、DES轉Base64的帖子。您看，轉了一圈，問題又回來了----那麽我們為什麽不直接在Base64編碼的基礎上來實現加密呢？為什麽要脫褲子放屁呢？！於是，打造一套輕量的、通用的、可讀的、開箱即用的加密方案，這，就是作者設計Nbed64的初衷！

2. Nbed64是一套[多語言] + [跨平臺]的加解密庫，Nbed64現已開源的語種有：GO版、C#版、C/C++版、Java版、Python版、JavaScript版、PHP版、E版，以及其它即將問世的語種版。這意味著，在所有主流編程語言中，但凡使用Nbed64加解密的數據，都均可無障礙交互。對不同語言的開發者，Nbed64的函數名，參數數量，參數位置， 執行結果，都是一致的、統一的。換句話說：使用Nbed64，前後端的開發者不論使用什麽語言，對結果的認識是統一的，是沒有分歧的，是可以無障礙交互數據的。

3. Nbed64是Network Bridge Encrypt Decrypt Base64的縮寫，它是一套通用的、開源的、跨語言的、跨平臺的卓越加密方案庫。這套庫的算法最早由合肥網橋網絡科技的CEO設計於2014年，當初僅有C++一個版本，隨後在其公司的生產環境中不斷擴充和叠代，發展成了今天的多語種版。因此nb指的就是網橋科技，ed指的是加密和解密，64指的是該算法基於Base64編碼框架。請不要誤以為nbed意指'非對稱的...'，這樣理解是錯誤的！強調一下， Nbed64是一套對稱的加密方案，以及升級版的對稱加密方案，人們很喜歡稱之為：動態加密方案！

4. Nbed64對字符集的編碼由內部算法實現，如：UTF-8，UTF-16，GBK等。它不依賴運行平臺的API，不依賴運行環境的API。這意味著：在Windows、Linux、Unix、Mac、Android、Ios等不同的平臺中運行的結果是一致的，安全的，穩定的。使用者使用跨平臺語言開發時不必關心各系統平臺之間的差異，也不必關心各種編碼API在不同系統平臺上使用的差異。開箱即用，編碼問題與您無關。

5. Nbed64解密字符串時，會自動轉換為當前語言的默認編碼。如JavaScript環境中，被解密的字符串會自動轉換為UTF-16，因為JavaScript的默認編碼就是UTF-16，也只有UTF-16才不會亂碼。強調一下，這裏"自動"所指的意思是：不論原內容是UTF-8編碼也好，是GBK編碼也罷，只要在JS裏解密字符串就必然是UTF-16，在C/C++裏解密就必然是UTF-8。這樣的設計很方便也很重要，眾所周知，不同編程語言的默認編碼是不同的，這意味著跨語言數據交互是需要彼此轉換編碼的，當彼此的默認編碼不同時，開發者需要知已知彼才能轉換編碼，這是繁瑣頭疼的過程。而Nbed64解決了這樣的尷尬，它在解密時扮演著自動翻譯者的工作。這讓開發者之間可以盡情的交互數據，而不必分散精力來處理彼此的編碼問題。

6. Nbed64為何選擇Base64作為加密框架呢？因為，二進製轉成字符集的常用方案有兩種：十六進製文本 和 Base64文本。其中十六進製需要兩個字符表示一個字節，因此，十六進製占用內存的尺寸為：X * 2，所以，會有1倍的空間浪費。而Base64則用4個字符表示3個字節，因此，Base64占用內存的尺寸為：X / 3 * 4，所以，只有3分之1的空間浪費。在網絡當道的今天，Nbed64只能選擇更節約的Base64編碼框架。同樣能滿足需求，當然要保持節約精神。

7. Nbed64的算法雖然基於Base64編碼框架，但算法經過大量優化，性能遠高於傳統的Base64算法。作者曾在多平臺下作過對比，各以10MB測試數據為例，Nbed64解密數據平均比傳統的base64解碼數據快100倍以上！主要原因是：傳統的Base64解碼時，通過遍歷查找Base64映射表中的字符串來尋址，而Nbed64直接通過計算推導來尋址，因此少了一層for()循環，再加上其它各種優化，性能便有了極大的提升。經過壓力測試，即使在移動瀏覽器中使用JavaScript編碼512MB的數據也迅捷快速、毫無壓力，其它語言和平臺的性能自不必多說了。

8. Nbed64使用Apache License 2.0 開源協議----Apache License 2.0 是當今最友好的開源協議之一。這意味著：任何個人、組織、企業、機構都可以隨意修改、轉發、共享、商用 Nbed64加密庫...



# 相關鏈接

### Nbed64 在GitHub上開源的其它語種版本
+ [C-Nbed64] 作者用 C/C++ 語言編寫的版本
+ [Go-Nbed64] 作者用 Golang 語言編寫的版本
+ [JS-Nbed64] 作者用 JavaScript 語言編寫的版本
+ [VB-Nbed64] 作者用 Visual Basic 語言編寫的版本
+ [CS-Nbed64] 作者用 C Sharp |  C# 語言編寫的版本
+ [PHP-Nbed64] 作者用 PHP 語言編寫的版本
+ [JAVA-Nbed64] 作者用 JAVA 語言編寫的版本
+ [Python-Nbed64] 作者用 Python 語言編寫的版本

*備註：由於編寫Demo和README需要大量的時間和精力，因此作者無法在短期內將以上所有的語種版本全部Push。不過別擔心，作者不會放松進度和改變計劃，彌補空缺只是時間問題....*

[c-Nbed64]: https://github.com/love915sss/js-nbed64-base64/
[Go-Nbed64]: https://github.com/love915sss/Go-Nbed64-base64/
[JS-Nbed64]: https://github.com/love915sss/js-nbed64-base64/
[VB-Nbed64]: https://github.com/love915sss/VB-Nbed64-base64/
[CS-Nbed64]: https://github.com/love915sss/CS-Nbed64-base64/
[PHP-Nbed64]: https://github.com/love915sss/PHP-Nbed64-base64/
[JAVA-Nbed64]: https://github.com/love915sss/JAVA-Nbed64-base64/
[Python-Nbed64]: https://github.com/love915sss/Python-Nbed64-base64/



## 環境要求

* PHP: 7.1+/8.0+

## 安裝

``` bash
$ composer require nbed64
```



# 函數原型 && DEMO

## 01. nbed64StringEncryptEx

### nbed64StringEncryptEx() Be used as dynamic encryption string, The data remains unchanged, The key remains unchanged, **But the encryption result is not repeated**

+ 函數原型：

```php
/**
 * Base64對字符串加密的升級版，簡稱：字符串動態加密（ 本函數與 nbed64StringDecryptEx()為一對 ）
 * @param str {string} 原數據。
 * @param key {string} 密鑰。理論上密鑰的長度與逆向的難度成正比關系。
 * @param isUtf8 {boolean} 是否采用UTF-8編碼格式。默認為：true。若設置為false，則使用UTF-16編碼。
 * 註意：此處指的是加密前的編碼，而非加密後的base64編碼，base64是無須編碼的。換句話來說，本參數指的是解密後的字符串編碼。
 * JS的默認編碼為UTF-16，但UTF-16並不友好，很多編程語言和服務端環境都不支持UTF-16。
 * @param maskNumber {number} 掩碼的數量。缺省為：32，範圍：32 - 65535。當值小於32時為32，大於65535時為65535。
 * @return 加密結果 {string} Base64格式的字符串
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

+ 函數原型：

```php
/**
 * Base64解密成字符串的升級版，簡稱：字符串動態解密（ 本函數與 nbed64StringEncryptEx()為一對 ）
 * @param {string} base64str base64格式的加密字符串
 * @param {string} key 密鑰。本參數請保持與加密時的設置完全一致。
 * @param {boolean} isUtf8 是否采用UTF-8編碼格式。本參數請保持與加密時的設置完全一致。（註意：這裏指的是加密前的編碼，並非解密後的編碼）
 * @return 解密結果 {string } 註意：結果為UTF-8編碼格式。為方便使用，PHP語言統一為UTF-8編碼。換句話說，在PHP中，本函數返回的必定是UTF-8。
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

+ 函數原型：

```php
/**
 * Base64對二進製數據加密的升級版，簡稱：二進製動態加密（ 本函數與 nbed64BinaryDecryptEx()為一對 ）
 * @param byteArr {ByteArray} 原數據。二進製字節數組，如：視頻、音頻、圖片、文件等。
 * @param key {string} 密鑰。理論上密鑰的長度與逆向的難度成正比關系。
 * @param maskNumber {number} 掩碼的數量。缺省為：32，範圍：32 - 65535。當值小於32時為32，大於65535時為65535。
 * @return 加密結果 {string} Base64格式的字符串
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

+ 函數原型：

```php
/**
 * Base64解密成二進製數據的升級版，簡稱：二進製動態解密（ 本函數與 nbed64BinaryEncryptEx()為一對 ）
 * @param base64str {string} base64格式的加密字符串
 * @param key {string} 密鑰。本參數請保持與加密時的設置完全一致。
 * @return 解密結果 {ByteArray} 為字節數組（也就是二進製數據流）
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

+ 函數原型：

```php
/**
 * Base64對字符串加密（ 本函數與 nbed64StringDecrypt()為一對 ）
 * @param str {string} 原數據。
 * @param key {string} 密鑰。理論上密鑰的長度與逆向的難度成正比關系。
 * @param isUtf8 {boolean} 是否采用UTF-8編碼格式。默認為：true。若設置為false，則使用UTF-16編碼。
 * 註意：此處指的是加密前的編碼，而非加密後的base64編碼，base64是無須編碼的。換句話來說，本參數指的是解密後的字符串編碼。
 * JS的默認編碼為UTF-16，但UTF-16並不友好，很多編程語言和服務端環境都不支持UTF-16。
 * @param isRFC4648 {boolean} 是否采用RFC4648編碼映射規範，默認為：true。采用RFC4648規範編碼的Base64符合URL安全，可用於HTTP協議與Ajax請求。
 * @return 加密結果 {string} Base64格式的字符串
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

+ 函數原型：

```php
/**
 * Base64解密成字符串（ 本函數與 nbed64StringEncrypt()為一對 ）
 * @param base64str {string} base64格式的加密字符串
 * @param key {string} 密鑰。本參數請保持與加密時的設置完全一致。
 * @param isUtf8 {boolean} 是否采用UTF-8編碼格式。本參數請保持與加密時的設置完全一致。（註意：這裏指的是加密前的編碼，並非解密後的編碼）
 * @return 解密結果 {string } 註意：結果為UTF-8編碼格式。為方便使用，PHP語言統一為UTF-8編碼。換句話說，在PHP中，本函數返回的必定是UTF-8。
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

+ 函數原型：

```php
/**
 * Base64對二進製數據加密（ 本函數與 nbed64BinaryDecrypt()為一對 ）
 * @param byteArr {byteArray} 原數據。二進製字節數組，如：視頻、音頻、圖片、文件等。
 * @param key {string} 密鑰。理論上密鑰的長度與逆向的難度成正比關系。
 * @param isRFC4648 {boolean} 是否采用isRFC4648編碼映射規範，默認為：true。采用isRFC4648規範編碼的Base64符合URL安全，可用於HTTP協議與Ajax請求。
 * @return 加密結果 {string} Base64格式的字符串
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

+ 函數原型：

```php
/**
 * Base64解密成二進製數據（ 本函數與 nbed64BinaryEncrypt()為一對 ）
 * @param base64str {string} base64格式的加密字符串
 * @param key {string} 密鑰。本參數請保持與加密時的設置完全一致。
 * @return 解密結果 {ByteArray} 為字節數組（也就是二進製數據流）
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

+ 函數原型：

```php
/**
 * Base64對字符串編碼（ 註意：這是編碼而非加密， 本函數與 nbed64StringDecode()為一對 ）
 * @param str {string} 原數據。
 * @param isUtf8 {boolean} 是否采用UTF-8編碼格式。默認為：true。若設置為false，則使用UTF-16編碼。
 * 註意：此處指的是編碼前的編碼，而非編碼後的base64編碼，base64是無須編碼的。換句話來說，本參數指的是解碼後的字符串編碼。
 * JS的默認編碼為UTF-16，但UTF-16並不友好，很多編程語言和服務端環境都不支持UTF-16。
 * @param isRFC4648 {boolean} 是否采用RFC4648編碼映射規範，默認為：true。采用RFC4648規範編碼的Base64符合URL安全，可用於HTTP協議與Ajax請求。
 * @return 編碼結果 {string} 標準Base64格式的字符串
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

+ 函數原型：

```php
/**
 * Base64解碼成字符串（ 註意：這是解碼而非解密， 本函數與 nbed64StringEncode()為一對 ）
 * @param base64str {string} base64格式編碼的字符串
 * @param isUtf8 {boolean} 是否采用UTF-8編碼格式。本參數請保持與編碼時的設置完全一致。
 * @return 解碼結果 {string } 註意：結果為UTF-16編碼格式。為方便使用，解碼結果會自動轉換成當前程序語言的默認編碼，以便開箱即用，省略二次編碼。JS默認編碼：UTF-16
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

+ 函數原型：

```php
/**
 * Base64對二進製數據編碼（ 註意：這是編碼而非加密， 本函數與 nbed64BinaryDecode()為一對 ）
 * @param byteArr {ByteArray} 原數據。二進製字節數組，如：視頻、音頻、圖片、文件等。
 * @param isRFC4648 {boolean} 是否采用RFC4648編碼映射規範，默認為：true。采用RFC4648規範編碼的Base64符合URL安全，可用於HTTP協議與Ajax請求。
 * @return 編碼結果 {string} 標準Base64格式的字符串
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

+ 函數原型：

```php
/**
 * Base64解碼成二進製數據（ 註意：這是解碼而非解密， 本函數與 nbed64BinaryEncode()為一對 ）
 * @param base64str {string} base64格式編碼的字符串
 * @return 解碼結果 {ByteArray} 為字節數組（也就是二進製數據流）
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

