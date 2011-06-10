使用php输出目录数，并计算文件/文件夹的大小，如

`
LICENSE (1.040K)
README.md (0.951K)
UPDATE.ja.md (23.951K)
UPDATE.md (19.390K)
autoload.php.dist (0.875K)
check_cs (3.312K)
phpunit.xml.dist (1.160K)
src (8302.127K)
    Symfony (8302.127K)
		Bridge (84.567K)
...
`

如果只是缩进输出目录结构，或者只是计算文件夹的大小都不是什么大问题，但如果要同时做到这两点，并且效率不能太低就有那么点挑战了。

输出目录结构是先序遍历，而计算文件夹大小需要后续遍历。我想了两个方法，cacl2优于cacl1，如果你有更好的想法，欢迎pull request :)
