# Kit
[![Build Status](https://travis-ci.org/wazsmwazsm/Kit.svg?branch=master)](https://travis-ci.org/wazsmwazsm/Kit)

工具箱，包含一些常用工具。

## 安装

```bash
composer require wazsmwazsm/kit
```

## 工具

### DotArr
用 a.b.c 格式的字符串作为数组的路径存储一个值。

设置：
```php
use Kit\DotArr;

$arr = [];
DotArr::dotSet($arr, 'foo.bar', 'hello');

var_dump($arr); // result is ['foo' => ['bar' => 'hello']]
```
读取：
```php
use Kit\DotArr;

$arr = ['foo' => ['bar' => 'hello']];
$result = DotArr::dotGet($arr, 'foo.bar');

var_dump($result); // result is hello

$result = DotArr::dotGet($arr, 'foo');

var_dump($result); // result is ['bar' => 'hello']


// 获取值不存在返回默认值
$result = DotArr::dotGet($arr, 'a.b', 'd');

var_dump($result); // result is d

```

判断值是否存在：
```php
use Kit\DotArr;

$arr = ['foo' => ['bar' => 'hello']];
$result = DotArr::dotHas($arr, 'foo.bar');
var_dump($result); // result is true
$result = DotArr::dotHas($arr, 'a.b');
var_dump($result); // result is false
```

### Pipeline

管道模式，将载荷送入管道，流过每一节管道，返回结果。

使用：
```php
use Kit\Pipeline;

$pipes = [
    function($payload) {
        return $payload + 1;
    },
    function($payload) {
        return $payload + 2;
    },
    function($payload) {
        return $payload + 3;
    },
];
// 初始化时设置管道
$pipe = new Pipeline($pipes);
// 添加管道
$pipe->pipe(function($payload) {
    return $payload + 4;
});

// 运行管道
$result = $pipe->flow(12);

var_dump($result); // result is 22
```

## License

The Kit is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
