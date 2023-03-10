<?php
declare(encoding='UTF-8');
namespace nbed64;

/**
 * Apache License 2.0 开源协议 && Apache License 2.0  open source agreement
 * Gitee: https://gitee.com/love915sss/php-nbed64-base64/
 * GitHub： https://github.com/love915sss/php-nbed64-base64/
 * Author Blog: https://blog.csdn.net/qq_16661383?type=blog
 */


class Nbed64
{
	/**
	 * Base64对二进制数据加密的升级版，简称：二进制动态加密（ 本函数与 nbed64BinaryDecryptEx()为一对 ）
	 * @param byteArr {ByteArray} 原数据。二进制字节数组，如：视频、音频、图片、文件等。
	 * @param key {string} 密钥。理论上密钥的长度与逆向的难度成正比关系。
	 * @param maskNumber {number} 掩码的数量。缺省为：32，范围：32 - 65535。当值小于32时为32，大于65535时为65535。
	 * @return 加密结果 {string} Base64格式的字符串
	 */
	public function nbed64BinaryEncryptEx($byteArr, $key, $maskNumber = 32)
	{
		$maskArr = $this->_maskToByteArray($maskNumber);
		$mapArr = $this->_mapToByteArray(true);
		$keyArr = $this->_keyToByteArray($key);
		$kl = sizeof($keyArr);
		$bl = sizeof($byteArr);
		$ml = sizeof($maskArr);
		$rem = $bl % 3;
		$num = $bl % 3 === 0 ? (int)($bl / 3) : (int)($bl / 3) + 1;
		$base64Len = $num * 4;
		$tempArr = array();
		$ba64Arr = array();
		$i = 0;
		$k = 0;
		$m = 0;
		$v = 0;
		$mk = 0;
		/* 加密并转换为字节数组 */
		for ($j = 0; $base64Len > $i; $j++) {
			$k = $j % $kl;
			$m = $j % $ml;
			$mk = ($keyArr[$k] + $maskArr[$m] | $keyArr[$k] | $maskArr[$m]) % 0xFF;
			$tempArr[0] = $byteArr[$v + 0] ^ $mk;
			$tempArr[1] = $byteArr[$v + 1] ^ $mk;
			$tempArr[2] = $byteArr[$v + 2] ^ $mk;
			$ba64Arr[$i + 0] = $mapArr[$tempArr[0] >> 2];
			$ba64Arr[$i + 1] = $mapArr[(($tempArr[0] & 0x03) << 4) + ($tempArr[1] >> 4)];
			$ba64Arr[$i + 2] = $mapArr[(($tempArr[1] & 0x0F) << 2) + ($tempArr[2] >> 6)];
			$ba64Arr[$i + 3] = $mapArr[$tempArr[2] & 0x3F];
			$i = $i + 4;
			$v = $v + 3;
		}
		/* 有余数时的尾部处理 */
		$rfc = $rem === 1 ? 2 : ($rem === 2 ? 1 : 0);
		/* byteArray转成String */
		$ba64String = "";
		for ($i = 0; $i < $base64Len - $rfc; $i++) {
			$ba64String .= chr($ba64Arr[$i]);
		}
		/* 编码掩码并插入到头部 */
		$topArr = array();
		array_push($topArr, 0, 0);
		for ($n = 0; $n < sizeof($maskArr); $n++) {
			$topArr[2 + $n] = $maskArr[$n];
		}
		/* 有余数时的补包处理(减掉首部长度标记包) */
		$tl = sizeof($topArr);
		$tf = $tl % 3 === 0 ? $tl : 3 - ($tl % 3);
		for ($n = 0; $n < $tf; $n++) {
			array_push($topArr, 0);
		}
		/* 合并数组后返回 */
		$lenArr = $this->_shortToByteArray(sizeof($topArr) - 2);
		$topArr[1] = $lenArr[1];
		$topArr[0] = $lenArr[0];
		$ba64Top = $this->nbed64BinaryEncrypt($topArr, $key, true);
		return $ba64Top . $ba64String;
	}


	/**
	 * Base64解密成二进制数据的升级版，简称：二进制动态解密（ 本函数与 nbed64BinaryEncryptEx()为一对 ）
	 * @param base64str {string} base64格式的加密字符串
	 * @param key {string} 密钥。本参数请保持与加密时的设置完全一致。
	 * @return 解密结果 {ByteArray} 为字节数组（也就是二进制数据流）
	 */
	public function nbed64BinaryDecryptEx($base64str, $key)
	{
		$topArr = $this->nbed64BinaryDecrypt(substr($base64str, 0, 4), $key);
		$maskLen = (int)$this->_byteArrayGetShort($topArr);
		$maskRem = $maskLen % 3;
		$maskMax = $maskRem === 0 ? $maskLen / 3 * 4 : $maskLen / 3 * 4 + (3 - $maskRem);
		$leftArr = $this->nbed64BinaryDecrypt(substr($base64str, 0, $maskMax + 4), $key);
		/* 提取掩饰的字节数组 */
		$maskArr = array();
		for ($i = 0; $i < $maskLen; $i++) {
			$maskArr[$i] = $leftArr[$i + 2];
		}
		$shift = $maskRem === 1 ? 1 : 3;
		$dataStart = $maskMax + $shift;
		$dataStr = substr($base64str, $dataStart, strlen($base64str));
		$bl = strlen($dataStr);
		$kl = strlen($key);
		$ml = sizeof($maskArr);
		$num = $bl % 4;
		$rem = $num === 0 ? 0 : 4 - $num;
		$loop = $rem === 0 ? (int)($bl / 4) : (int)($bl / 4) + 1;
		$nl = $loop * 3;
		/* 填充被省略的'='字符'----为了遵循严谨的编程精神（JS中可选，其它语言中必须） */
		$fill = '';
		for ($i = 0; $i < $rem; $i++) {
			$fill .= '=';
		}
		$dataStr .= $fill;
		/* 将字符串换为字节数组 */
		$keyArr = $this->_keyToByteArray($key);
		$baseUint8Arr = $this->_base64strToByteArray($dataStr);
		$newArr = array();
		$h = 0;
		$i = 0;
		$k = 0;
		$j = -1;
		$m = -1;
		$mk = 0;
		/* 解密并转换为字节数组 */
		for ($w = 0; $w < $loop; $w++) {
			$j++;
			$k = $j % $kl;
			$m = $j % $ml;
			$mk = ($keyArr[$k] + $maskArr[$m] | $keyArr[$k] | $maskArr[$m]) % 0xFF;
			$tempArr = array();
			/* 本方式性能卓越，无需遍历base64映射表，直接计算映射关系 */
			for ($y = 0; $y < 4; $y++) {
				$n = 0;
				$p = $w * 4 + $y;
				$b = $baseUint8Arr[$p];
				if ($b >= 65 && $b <= 90) {
					/* ABCDEFGHIJKLMNOPQRSTUVWXYZ */
					$n = $b - 65;
				} else if ($b >= 97 && $b <= 122) {
					/* abcdefghijklmnopqrstuvwxyz */
					$shifting = 26;
					$n = $b - 97 + $shifting;
				} else if ($b >= 48 && $b <= 57) {
					/* 0123456789 */
					$shifting = 52;
					$n = $b - 48 + $shifting;
				} else if ($b === 43 || $b === 45) {
					/* '+' === 43 || '-' ==== 45 */
					$n = 62;
				} else if ($b === 47 || $b === 95) {
					/* '/' === 47 || '_' === 95 */
					$n = 63;
				} else {
					$h++;
				}
				$tempArr[$y] = $n;
			}
			$d1 = $tempArr[0] << 2 | $tempArr[1] >> 4;
			$d2 = ($tempArr[1] & 15) << 4 | $tempArr[2] >> 2;
			$d3 = ($tempArr[2] & 3) << 6 | $tempArr[3];
			$newArr[$i + 0] = $d1 ^ $mk;
			$newArr[$i + 1] = $d2 ^ $mk;
			$newArr[$i + 2] = $d3 ^ $mk;
			$i += 3;
		}
		/* byteArray转成String----为跨平台的兼容性不使用Array.slice */
		$retLen = sizeof($newArr) - $h;
		$retArr = array();
		for ($n = 0; $n < $retLen; $n++) {
			$retArr[$n] = $newArr[$n];
		}
		return $retArr;
	}


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
	public function nbed64StringEncryptEx($str, $key, $isUtf8 = true, $maskNumber = 32)
	{
		$byteArr = $isUtf8 ? $this->_Utf8DirectToByteArray($str) : $this->_strUtf8ToUtf16ToByteArray($str);
		return $this->nbed64BinaryEncryptEx($byteArr, $key, $maskNumber);
	}


	/**
	 * Base64解密成字符串的升级版，简称：字符串动态解密（ 本函数与 nbed64StringEncryptEx()为一对 ）
	 * @param {string} base64str base64格式的加密字符串
	 * @param {string} key 密钥。本参数请保持与加密时的设置完全一致。
	 * @param {boolean} isUtf8 是否采用UTF-8编码格式。本参数请保持与加密时的设置完全一致。（注意：这里指的是加密前的编码，并非解密后的编码）
	 * @return 解密结果 {string } 注意：结果为UTF-8编码格式。为方便使用，PHP语言统一为UTF-8编码。换句话说，在PHP中，本函数返回的必定是UTF-8。
	 */
	public function nbed64StringDecryptEx($base64str, $key, $isUtf8 = true)
	{
		$retArr = $this->nbed64BinaryDecryptEx($base64str, $key);
		$dataStr = $isUtf8 ? $this->_byteArrayDirectToUtf8($retArr) : $this->_byteArrayToUtf16ToUtf8($retArr);
		return $dataStr;
	}


	/**
	 * Base64对二进制数据加密（ 本函数与 nbed64BinaryDecrypt()为一对 ）
	 * @param byteArr {byteArray} 原数据。二进制字节数组，如：视频、音频、图片、文件等。
	 * @param key {string} 密钥。理论上密钥的长度与逆向的难度成正比关系。
	 * @param isRFC4648 {boolean} 是否采用isRFC4648编码映射规范，默认为：true。采用isRFC4648规范编码的Base64符合URL安全，可用于HTTP协议与Ajax请求。
	 * @return 加密结果 {string} Base64格式的字符串
	 */
	public function nbed64BinaryEncrypt($byteArr, $key, $isRFC4648 = true)
	{
		$mapArr = $this->_mapToByteArray($isRFC4648);
		$keyArr = $this->_keyToByteArray($key);
		$kl = sizeof($keyArr);
		$bl = sizeof($byteArr);
		$rem = $bl % 3;
		$num = $bl % 3 === 0 ? (int)($bl / 3) : (int)($bl / 3) + 1;
		$base64Len = $num * 4;
		$tempArr = array();
		$ba64Arr = array();
		$i = 0;
		$k = 0;
		$v = 0;
		/* 加密并转换为字节数组 */
		for ($j = 0; $base64Len > $i; $j++) {
			$k = $j % $kl;
			$tempArr[0] = ($byteArr[$v + 0] ^ $keyArr[$k]) % 0xFF;
			$tempArr[1] = ($byteArr[$v + 1] ^ $keyArr[$k]) % 0xFF;
			$tempArr[2] = ($byteArr[$v + 2] ^ $keyArr[$k]) % 0xFF;
			$ba64Arr[$i + 0] = $mapArr[$tempArr[0] >> 2];
			$ba64Arr[$i + 1] = $mapArr[(($tempArr[0] & 0x03) << 4) + ($tempArr[1] >> 4)];
			$ba64Arr[$i + 2] = $mapArr[(($tempArr[1] & 0x0F) << 2) + ($tempArr[2] >> 6)];
			$ba64Arr[$i + 3] = $mapArr[$tempArr[2] & 0x3F];
			$i = $i + 4;
			$v = $v + 3;
		}
		/* 有余数时的尾部处理 */
		$rfc = 0;
		if (!$isRFC4648) {
			if ($rem === 1) {
				$ba64Arr[$base64Len - 2] = 0x3D;
				$ba64Arr[$base64Len - 1] = 0x3D;
			} else if ($rem === 2) {
				$ba64Arr[$base64Len - 1] = 0x3D;
			}
		} else {
			if ($rem === 1) {
				$rfc = 2;
			} else if ($rem === 2) {
				$rfc = 1;
			} else {
				$rfc = 0;
			}
		}
		/* $byteArray转成String */
		$ba64String = "";
		for ($i = 0; $i < $base64Len - $rfc; $i++) {
			$ba64String .= chr($ba64Arr[$i]);
		}
		return $ba64String;
	}


	/**
	 * Base64解密成二进制数据（ 本函数与 nbed64BinaryEncrypt()为一对 ）
	 * @param base64str {string} base64格式的加密字符串
	 * @param key {string} 密钥。本参数请保持与加密时的设置完全一致。
	 * @return 解密结果 {ByteArray} 为字节数组（也就是二进制数据流）
	 */
	public function nbed64BinaryDecrypt($base64str, $key)
	{
		$bl = strlen($base64str);
		$kl = strlen($key);
		$num = $bl % 4;
		$rem = $num === 0 ? 0 : 4 - $num;
		$loop = $rem === 0 ? (int)($bl / 4) : (int)($bl / 4) + 1;
		$nl = $loop * 3;
		/* 填充被省略的'='字符'----为了遵循严谨的编程精神（JS中可选，其它语言中必须） */
		$fill = '';
		for ($i = 0; $i < $rem; $i++) {
			$fill .= '=';
		}
		$base64str .= $fill;
		/* 将字符串换为字节数组 */
		$keyArr = $this->_keyToByteArray($key);
		$baseUint8Arr = $this->_base64strToByteArray($base64str);
		$newArr = array();
		$h = 0;
		$i = 0;
		$j = -1;
		$k = 0;
		/* 解密并转换为字节数组 */
		for ($w = 0; $w < $loop; $w++) {
			$j++;
			$k = $j % $kl;
			$tempArr = array();
			/* 本方式性能卓越，无需遍历base64映射表，直接计算映射关系 */
			for ($y = 0; $y < 4; $y++) {
				$n = 0;
				$p = $w * 4 + $y;
				$b = $baseUint8Arr[$p];
				if ($b >= 65 && $b <= 90) {
					/* ABCDEFGHIJKLMNOPQRSTUVWXYZ */
					$n = $b - 65;
				} else if ($b >= 97 && $b <= 122) {
					/* abcdefghijklmnopqrstuvwxyz */
					$shifting = 26;
					$n = $b - 97 + $shifting;
				} else if ($b >= 48 && $b <= 57) {
					/* 0123456789 */
					$shifting = 52;
					$n = $b - 48 + $shifting;
				} else if ($b === 43 || $b === 45) {
					/* '+' === 43 || '-' ==== 45 */
					$n = 62;
				} else if ($b === 47 || $b === 95) {
					/* '/' === 47 || '_' === 95 */
					$n = 63;
				} else {
					$h++;
				}
				$tempArr[$y] = $n;
			}
			$d1 = $tempArr[0] << 2 | $tempArr[1] >> 4;
			$d2 = ($tempArr[1] & 15) << 4 | $tempArr[2] >> 2;
			$d3 = ($tempArr[2] & 3) << 6 | $tempArr[3];
			$newArr[$i + 0] = $d1 ^ $keyArr[$k];
			$newArr[$i + 1] = $d2 ^ $keyArr[$k];
			$newArr[$i + 2] = $d3 ^ $keyArr[$k];
			$i += 3;
		}
		/* byteArray转成String----为跨平台的兼容性不使用Array.slice */
		$retLen = sizeof($newArr) - $h;
		$retArr = array();
		for ($n = 0; $n < $retLen; $n++) {
			$retArr[$n] = $newArr[$n];
		}
		return $retArr;
	}


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
	public function nbed64StringEncrypt($str, $key, $isUtf8 = true, $isRFC4648 = true)
	{
		$byteArr = $isUtf8 ? $this->_Utf8DirectToByteArray($str) : $this->_strUtf8ToUtf16ToByteArray($str);
		return $this->nbed64BinaryEncrypt($byteArr, $key, $isRFC4648);
	}

	/**
	 * Base64解密成字符串（ 本函数与 nbed64StringEncrypt()为一对 ）
	 * @param base64str {string} base64格式的加密字符串
	 * @param key {string} 密钥。本参数请保持与加密时的设置完全一致。
	 * @param isUtf8 {boolean} 是否采用UTF-8编码格式。本参数请保持与加密时的设置完全一致。（注意：这里指的是加密前的编码，并非解密后的编码）
	 * @return 解密结果 {string } 注意：结果为UTF-8编码格式。为方便使用，PHP语言统一为UTF-8编码。换句话说，在PHP中，本函数返回的必定是UTF-8。
	 */
	public function nbed64StringDecrypt($base64str, $key, $isUtf8 = true)
	{
		$retArr = $this->nbed64BinaryDecrypt($base64str, $key);
		$dataStr = $isUtf8 ? $this->_byteArrayDirectToUtf8($retArr) : $this->_byteArrayToUtf16ToUtf8($retArr);
		return $dataStr;
	}


	/**
	 * Base64对二进制数据编码（ 注意：这是编码而非加密， 本函数与 nbed64BinaryDecode()为一对 ）
	 * @param byteArr {ByteArray} 原数据。二进制字节数组，如：视频、音频、图片、文件等。
	 * @param isRFC4648 {boolean} 是否采用RFC4648编码映射规范，默认为：true。采用RFC4648规范编码的Base64符合URL安全，可用于HTTP协议与Ajax请求。
	 * @return 编码结果 {string} 标准Base64格式的字符串
	 */
	public function nbed64BinaryEncode($byteArr, $isRFC4648 = true)
	{
		$mapArr = $this->_mapToByteArray($isRFC4648);
		$bl = sizeof($byteArr);
		$rem = $bl % 3;
		$num = $bl % 3 === 0 ? (int)($bl / 3) : (int)($bl / 3) + 1;
		$base64Len = $num * 4;
		$ba64Arr = array();
		$i = 0;
		$v = 0;
		/* 编码并转换为字节数组 */
		for (; $base64Len > $i; $i = $i + 4) {
			$ba64Arr[$i + 0] = $mapArr[$byteArr[$v + 0] >> 2];
			$ba64Arr[$i + 1] = $mapArr[(($byteArr[$v + 0] & 0x03) << 4) + ($byteArr[$v + 1] >> 4)];
			$ba64Arr[$i + 2] = $mapArr[(($byteArr[$v + 1] & 0x0F) << 2) + ($byteArr[$v + 2] >> 6)];
			$ba64Arr[$i + 3] = $mapArr[$byteArr[$v + 2] & 0x3F];
			$v = $v + 3;
		}
		/* 有余数时的尾部处理 */
		$rfc = 0;
		if (!$isRFC4648) {
			if ($rem === 1) {
				$ba64Arr[$base64Len - 2] = 0x3D;
				$ba64Arr[$base64Len - 1] = 0x3D;
			} else if ($rem === 2) {
				$ba64Arr[$base64Len - 1] = 0x3D;
			}
		} else {
			if ($rem === 1) {
				$rfc = 2;
			} else if ($rem === 2) {
				$rfc = 1;
			} else {
				$rfc = 0;
			}
		}
		/* byteArray转成String */
		$ba64String = "";
		for ($i = 0; $i < $base64Len - $rfc; $i++) {
			$ba64String .= chr($ba64Arr[$i]);
		}
		return $ba64String;
	}


	/**
	 * Base64解码成二进制数据（ 注意：这是解码而非解密， 本函数与 nbed64BinaryEncode()为一对 ）
	 * @param base64str {string} base64格式编码的字符串
	 * @return 解码结果 {ByteArray} 为字节数组（也就是二进制数据流）
	 */
	public function nbed64BinaryDecode($base64str)
	{
		$bl = strlen($base64str);
		$num = $bl % 4;
		$rem = $num === 0 ? 0 : 4 - $num;
		$loop = $rem === 0 ? (int)($bl / 4) : (int)($bl / 4) + 1;
		$nl = $loop * 3;
		/* 填充被省略的'='字符'----为了遵循严谨的编程精神（JS中可选，其它语言中必须） */
		$fill = '';
		for ($i = 0; $i < $rem; $i++) {
			$fill .= '=';
		}
		$base64str .= $fill;
		/* 将字符串换为字节数组 */
		$baseUint8Arr = $this->_base64strToByteArray($base64str);
		$newArr = array();
		$h = 0;
		$i = 0;
		/* 解码并转换为字节数组 */
		for ($w = 0; $w < $loop; $w++) {
			$tempArr = array();
			/* 本方式性能卓越，无需遍历base64映射表，直接计算映射关系 */
			for ($y = 0; $y < 4; $y++) {
				$n = 0;
				$p = $w * 4 + $y;
				$b = $baseUint8Arr[$p];
				if ($b >= 65 && $b <= 90) {
					/* ABCDEFGHIJKLMNOPQRSTUVWXYZ */
					$n = $b - 65;
				} else if ($b >= 97 && $b <= 122) {
					/* abcdefghijklmnopqrstuvwxyz */
					$shifting = 26;
					$n = $b - 97 + $shifting;
				} else if ($b >= 48 && $b <= 57) {
					/* 0123456789 */
					$shifting = 52;
					$n = $b - 48 + $shifting;
				} else if ($b === 43 || $b === 45) {
					/* '+' === 43 || '-' ==== 45 */
					$n = 62;
				} else if ($b === 47 || $b === 95) {
					/* '/' === 47 || '_' === 95 */
					$n = 63;
				} else {
					$h++;
				}
				$tempArr[$y] = $n;
			}
			$newArr[$i + 0] = $tempArr[0] << 2 | $tempArr[1] >> 4;
			$newArr[$i + 1] = ($tempArr[1] & 15) << 4 | $tempArr[2] >> 2;
			$newArr[$i + 2] = ($tempArr[2] & 3) << 6 | $tempArr[3];
			$i += 3;
		}
		/* byteArray转成String----为跨平台的兼容性不使用Array.slice */
		$retLen = sizeof($newArr);
		$retArr = array();
		for ($n = 0; $n < $retLen; $n++) {
			$retArr[$n] = $newArr[$n];
		}
		return $retArr;
	}


	/**
	 * Base64对字符串编码（ 注意：这是编码而非加密， 本函数与 nbed64StringDecode()为一对 ）
	 * @param str {string} 原数据。
	 * @param isUtf8 {boolean} 是否采用UTF-8编码格式。默认为：true。若设置为false，则使用UTF-16编码。
	 * 注意：此处指的是编码前的编码，而非编码后的base64编码，base64是无须编码的。换句话来说，本参数指的是解码后的字符串编码。
	 * JS的默认编码为UTF-16，但UTF-16并不友好，很多编程语言和服务端环境都不支持UTF-16。
	 * @param isRFC4648 {boolean} 是否采用RFC4648编码映射规范，默认为：true。采用RFC4648规范编码的Base64符合URL安全，可用于HTTP协议与Ajax请求。
	 * @return 编码结果 {string} 标准Base64格式的字符串
	 */
	public function nbed64StringEncode($str, $isUtf8 = true, $isRFC4648 = true)
	{
		$byteArr = $isUtf8 ? $this->_Utf8DirectToByteArray($str) : $this->_strUtf8ToUtf16ToByteArray($str);
		return $this->nbed64BinaryEncode($byteArr, $isRFC4648);
	}


	/**
	 * Base64解码成字符串（ 注意：这是解码而非解密， 本函数与 nbed64StringEncode()为一对 ）
	 * @param base64str {string} base64格式编码的字符串
	 * @param isUtf8 {boolean} 是否采用UTF-8编码格式。本参数请保持与编码时的设置完全一致。
	 * @return 解码结果 {string } 注意：结果为UTF-16编码格式。为方便使用，解码结果会自动转换成当前程序语言的默认编码，以便开箱即用，省略二次编码。JS默认编码：UTF-16
	 */
	public function nbed64StringDecode($base64str, $isUtf8 = true)
	{
		$retArr = $this->nbed64BinaryDecode($base64str);
		$dataStr = $isUtf8 ? $this->_byteArrayDirectToUtf8($retArr) : $this->_byteArrayToUtf16ToUtf8($retArr);
		return $dataStr;
	}


	/**
	 * string按Utf-16编码方式转为byteArray（字符串按Utf-16编码转为字节数组）。
	 * 编码过程步骤：1.str（按UTF8）转为UTF-16，2.再按UTF-16转字节数组。
	 * @summary PHP的默认编码是ISO-8859-1，但由于PHP的编码可以通过header()设置，因此大家常用的都是UTF8。但JS不同，JS的默认编码是UTF-16，而且无法修改设置默认编码！
	 * @param str {string} 原字符串。
	 * @return 转换结果为字节数组（也就是二进制数据流） {ByteArray} 
	 */
	private function _strUtf8ToUtf16ToByteArray($str)
	{
		$i = 0;
		$k = 0;
		$short = 0;
		$byteArr = array();
		$strLen = strlen($str);
		while ($strLen > $i) {
			$t = ord($str[$i]);
			if ($t >> 3 === 0x1E) {
				$a = ord($str[$i + 0]) % 0xF0;
				$b = ord($str[$i + 1]) % 0x80;
				$c = ord($str[$i + 2]) % 0x80;
				$d = ord($str[$i + 3]) % 0x80;
				$short = ($a << 18) + ($b << 12) + ($c << 6) + $d;
				$i += 4;
			} else if ($t >> 4 === 0x0E) {
				$a = ord($str[$i + 0]) % 0xE0;
				$b = ord($str[$i + 1]) % 0x80;
				$c = ord($str[$i + 2]) % 0x80;
				$short = ($a << 12) + ($b << 6) + $c;
				$i += 3;
			} else if ($t >> 5 === 0x06) {
				$a = ord($str[$i + 0]) % 0xC0;
				$b = ord($str[$i + 1]) % 0x80;
				$short = ($a << 6) + $b;
				$i += 2;
			} else {
				$short = ord($str[$i + 0]);
				$i++;
			}
			$uft16Bytes = $this->_shortToByteArray($short);
			$byteArr[$k++] = $uft16Bytes[0];
			$byteArr[$k++] = $uft16Bytes[1];
		}
		/* 直接修正不能被3正除 */
		$rem = sizeof($byteArr) % 3;
		$add = $rem === 0 ? 0 : 3 - $rem;
		for ($i = 0; $i < $add; $i++) {
			array_push($byteArr, 0);
		}
		return $byteArr;
	}


	/**
	 * string按Utf-8编码方式转为byteArray（字符串按Utf-8编码转为字节数组）。
	 * @summary PHP的默认编码是ISO-8859-1，但由于PHP的编码可以通过header()设置，因此大家常用的都是UTF8。但JS不同，JS的默认编码是UTF-16，而且无法修改设置默认编码！
	 * @param str {string} 原字符串。
	 * @return 转换结果为字节数组（也就是二进制数据流） {ByteArray} 
	 */
	private function _Utf8DirectToByteArray($str)
	{
		$i = 0;
		$byteArr = array();
		$strLen = strlen($str);
		for ($i = 0; $i < $strLen; $i++) {
			array_push($byteArr, ord($str[$i]));
		}
		/* 直接修正不能被3正除 */
		$rem = $strLen % 3;
		$add = $rem === 0 ? 0 : 3 - $rem;
		for ($i = 0; $i < $add; $i++) {
			array_push($byteArr, 0);
		}
		return $byteArr;
	}


	/**
	 * byteArray按UTF8解码转成String（字节数组按UTF16解码成字符串 ）
	 *  解码过程步骤：1.byteArray（按UTF16）转为UTF-16，2.UTF-16转字符串。
	 * @param byteArr {Uint8Array} 原字符串。
	 * @return 转换结果为字符串 {String}
	 */
	private function _byteArrayToUtf16($byteArr)
	{
		$i = 0;
		$utf16Str = '';
		$strLen = sizeof($byteArr);
		while ($strLen > $i) {
			$utf16Str .= chr($byteArr[$i++]) . chr($byteArr[$i++]);
		}
		return $utf16Str;
	}


	/**
	 * byteArray按UTF8解码转成String（字节数组按UTF8解码成字符串，注意：JS中字符串默认编码为UTF-16， 而不是UTF-8 ）
	 * 解码过程步骤：1.byteArray（按UTF8）转为UTF-16，2.UTF-16转字符串。
	 * @param byteArr {Uint8Array}  原字符串。
	 * @return 转换结果为字符串 {String}
	 */
	private function _byteArrayToUtf16ToUtf8($byteArr)
	{
		$utf16Str = '';
		$strLen = count($byteArr);
		$strLen = $strLen % 2 === 0 ? $strLen : $strLen - 1;
		if ($strLen < 2) {
			echo 'error.....' . $strLen;
			return '';
		}
		for ($i = 0; $strLen > $i; $i += 2) {
			$str = '';
			$x = $byteArr[$i + 0];
			$y = $byteArr[$i + 1];
			$short = $x + ($y << 8);
			if ($short > 0xFFFF) {
				$a = (0xF0 | (0x07 & ($short >> 18)));
				$b = (0x80 | (0x3F & ($short >> 12)));
				$c = (0x80 | (0x3F & ($short >> 6)));
				$d = (0x80 | (0x3F & $short));
				$str = chr($a) . chr($b) . chr($c) . chr($d);
			} else if ($short > 0x7FF) {
				$a = (0xE0 | (0x0F & ($short >> 12)));
				$b = (0x80 | (0x3F & ($short >> 6)));
				$c = (0x80 | (0x3F & $short));
				$str = chr($a) . chr($b) . chr($c);
			} else if ($short > 0x7F) {
				$a = (0xC0 | (0x1F & ($short >> 6)));
				$b = (0x80 | (0x3F & $short));
				$str = chr($a) . chr($b);
			} else {
				$str = chr($short);
			}
			$utf16Str .= $str;
		}
		return $utf16Str;
	}


	/**
	 * byteArray按UTF8解码转成String（字节数组按UTF8解码成字符串，通常PHP中用UTF-8编码，所以和JS不同，需要用此函数 ）
	 * 解码过程步骤：1.byteArray（按UTF8）转为UTF-8，2.UTF-8转字符串。（这个在PHP里可以直接转换，很简单）
	 * @param byteArr {Uint8Array}  原字符串。
	 * @return 转换结果为字符串 {String}
	 */
	private function _byteArrayDirectToUtf8($byteArr)
	{
		$i = 0;
		$utf16Str = '';
		$strLen = count($byteArr);
		while ($strLen > $i) {
			$str = '';
			$t = $byteArr[$i];
			if ($t >> 3 === 0x1E) {
				$a = $byteArr[$i + 0];
				$b = $byteArr[$i + 1];
				$c = $byteArr[$i + 2];
				$d = $byteArr[$i + 3];
				$str = chr($a) . chr($b) . chr($c) . chr($d);
				$i += 4;
			} else if ($t >> 4 === 0x0E) {
				$a = $byteArr[$i + 0];
				$b = $byteArr[$i + 1];
				$c = $byteArr[$i + 2];
				$str = chr($a) . chr($b) . chr($c);
				$i += 3;
			} else if ($t >> 5 === 0x06) {
				$a = $byteArr[$i + 0];
				$b = $byteArr[$i + 1];
				$str = chr($a) . chr($b);
				$i += 2;
			} else {
				$a = $byteArr[$i + 0];
				$str = chr($a);
				$i++;
			}
			$utf16Str .= $str;
		}
		return $utf16Str;
	}


	/**
	 * ba64String转为byteArray（字符串转字节数组, base64专用）
	 * @param base64str {string} base64格式的字符串
	 * @return 转换结果为字节数组（也就是二进制数据流） {ByteArray} 
	 */
	private function _base64strToByteArray($base64str)
	{
		$realLen = strlen($base64str);
		$byteArr = array();
		for ($i = 0; $i < $realLen; $i++) {
			$byteArr[$i] = ord($base64str[$i]);
		}
		return $byteArr;
	}


	/**
	 * key转为byteArray（字符串转字节数组, 密钥专用）
	 * @param key {string} 密钥
	 * @return 转换结果为字节数组（也就是二进制数据流） {ByteArray} 
	 */
	private function _keyToByteArray($key)
	{
		$byteArr = array();
		for ($i = 0; $i < strlen($key); $i++) {
			$byteArr[$i] = ord($key[$i]);
		}
		return $byteArr;
	}


	/**
	 * short转为byteArray（短整数转字节数组）
	 * @param twoByte {short}  短整数。
	 * @return 转换结果为字节数组（也就是二进制数据流） {ByteArray} 
	 */
	private function _shortToByteArray($twoByte)
	{
		$byteArr = array();
		$byteArr[0] = $twoByte & 0xFF;;
		$byteArr[1] = ($twoByte - $byteArr[0]) / 0x100;
		return $byteArr;
	}

	/**
	 * 从base64中提取short（ 提取mask的长度 ）
	 * @param byteArr {Uint8Array} base64头部字节数组。
	 * @return 表示mask的长度 {short} 
	 */
	private function _byteArrayGetShort($byteArr)
	{
		$maskLen = ($byteArr[1] << 8) + $byteArr[0];
		return $maskLen;
	}


	/**
	 * 取随机掩码
	 * @param maskNumber {number} 掩码的数量。缺省为：32，范围：32 - 65535。当值小于32时为32，大于65535时为65535。
	 * @return 转换结果为字节数组（也就是二进制数据流） {ByteArray} 
	 */
	private function _maskToByteArray($maskNumber)
	{
		$maskNumber = $maskNumber < 32 ? 32 : $maskNumber;
		$maskNumber = $maskNumber > 65535 ? 65535 : $maskNumber;
		$byteArr = array();
		for ($i = 0; $i < $maskNumber; $i++) {
			$byteArr[$i] = rand(0, 255);
		}
		return $byteArr;
	}


	/**
	 * key转为byteArray（字符串转字节数组, base64编码映射表专用）
	 * @param rfc4648 {boolean} 是否使用RFC4648映射标准，默认为：false
	 * @return 转换结果为字节数组（也就是二进制数据流） {ByteArray} 
	 */
	private function _mapToByteArray($rfc4648 = false)
	{
		$map = '';
		if ($rfc4648) {
			/* 以'-_'结尾的映射表为RFC4648标准的安全URL国际规范，主要用与HTTP协议，如：Ajax请求 */
			$map = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';
		} else {
			/* 以'+/'结尾的映射表为国际统一的原生标准。但URL请求中：+会被转成空格，/会被解析成路径，因此不符合URL安全 */
			$map = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
		}
		$byteArr = array();
		for ($i = 0; $i < strlen($map); $i++) {
			//$byteArr[$i] = ord($map[$i]);
			array_push($byteArr, ord($map[$i]));
		}
		return $byteArr;
	}
}
