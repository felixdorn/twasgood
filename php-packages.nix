{composerEnv, fetchurl, fetchgit ? null, fetchhg ? null, fetchsvn ? null, noDev ? false}:

let
  packages = {
    "aws/aws-crt-php" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "aws-aws-crt-php-d71d9906c7bb63a28295447ba12e74723bd3730e";
        src = fetchurl {
          url = "https://api.github.com/repos/awslabs/aws-crt-php/zipball/d71d9906c7bb63a28295447ba12e74723bd3730e";
          sha256 = "1giqdlzja742di06qychsi8w12hy4dmaajzgl7jhcpwqqyi4xh42";
        };
      };
    };
    "aws/aws-sdk-php" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "aws-aws-sdk-php-41bcd4a555649d276c8fbc0bc1738e59fda2221d";
        src = fetchurl {
          url = "https://api.github.com/repos/aws/aws-sdk-php/zipball/41bcd4a555649d276c8fbc0bc1738e59fda2221d";
          sha256 = "0hnn5975fbdhiy1n148mmzj4asrscmzgxaxa2h6ns7lnrrd6s6bq";
        };
      };
    };
    "brick/math" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "brick-math-f510c0a40911935b77b86859eb5223d58d660df1";
        src = fetchurl {
          url = "https://api.github.com/repos/brick/math/zipball/f510c0a40911935b77b86859eb5223d58d660df1";
          sha256 = "1cgj6qfjjl76jyjxxkdmnzl0sc8y3pkvcw91lpjdlp4jnqlq31by";
        };
      };
    };
    "carbonphp/carbon-doctrine-types" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "carbonphp-carbon-doctrine-types-18ba5ddfec8976260ead6e866180bd5d2f71aa1d";
        src = fetchurl {
          url = "https://api.github.com/repos/CarbonPHP/carbon-doctrine-types/zipball/18ba5ddfec8976260ead6e866180bd5d2f71aa1d";
          sha256 = "04vcxjgynvjaz3k1lws1a8cydxiw8blb4iz2xkawq8579rxdiq7v";
        };
      };
    };
    "composer/semver" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "composer-semver-4313d26ada5e0c4edfbd1dc481a92ff7bff91f12";
        src = fetchurl {
          url = "https://api.github.com/repos/composer/semver/zipball/4313d26ada5e0c4edfbd1dc481a92ff7bff91f12";
          sha256 = "1gn5zdhhdan27v6cs6wlw7zz4ga2d5a4j0934nh52qi3idpm358d";
        };
      };
    };
    "dflydev/dot-access-data" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "dflydev-dot-access-data-a23a2bf4f31d3518f3ecb38660c95715dfead60f";
        src = fetchurl {
          url = "https://api.github.com/repos/dflydev/dflydev-dot-access-data/zipball/a23a2bf4f31d3518f3ecb38660c95715dfead60f";
          sha256 = "0j0rywsfpna100ygdk5f2ngijc8cp785szz84274mq8gdzhan06l";
        };
      };
    };
    "doctrine/inflector" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "doctrine-inflector-5817d0659c5b50c9b950feb9af7b9668e2c436bc";
        src = fetchurl {
          url = "https://api.github.com/repos/doctrine/inflector/zipball/5817d0659c5b50c9b950feb9af7b9668e2c436bc";
          sha256 = "0yj0f6w0v35d0xdhy4bf7hsjrkjjxsglc879rdciybsk6vz70g96";
        };
      };
    };
    "doctrine/lexer" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "doctrine-lexer-31ad66abc0fc9e1a1f2d9bc6a42668d2fbbcd6dd";
        src = fetchurl {
          url = "https://api.github.com/repos/doctrine/lexer/zipball/31ad66abc0fc9e1a1f2d9bc6a42668d2fbbcd6dd";
          sha256 = "1yaznxpd1d8h3ij262hx946nqvhzsgjmafdgnxbaiarc6nslww25";
        };
      };
    };
    "dragonmantank/cron-expression" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "dragonmantank-cron-expression-8c784d071debd117328803d86b2097615b457500";
        src = fetchurl {
          url = "https://api.github.com/repos/dragonmantank/cron-expression/zipball/8c784d071debd117328803d86b2097615b457500";
          sha256 = "1zamydhfqww233055i7199jqpn6cjxm00r5mfa6mix3fnbbff7n1";
        };
      };
    };
    "egulias/email-validator" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "egulias-email-validator-b115554301161fa21467629f1e1391c1936de517";
        src = fetchurl {
          url = "https://api.github.com/repos/egulias/EmailValidator/zipball/b115554301161fa21467629f1e1391c1936de517";
          sha256 = "0qnd4pc6hk47vr8vilafw4cpzxjgfjyipaml6vp6mdr8zmjnk1d1";
        };
      };
    };
    "fruitcake/php-cors" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "fruitcake-php-cors-3d158f36e7875e2f040f37bc0573956240a5a38b";
        src = fetchurl {
          url = "https://api.github.com/repos/fruitcake/php-cors/zipball/3d158f36e7875e2f040f37bc0573956240a5a38b";
          sha256 = "1pdq0dxrmh4yj48y9azrld10qmz1w3vbb9q81r85fvgl62l2kiww";
        };
      };
    };
    "graham-campbell/result-type" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "graham-campbell-result-type-3ba905c11371512af9d9bdd27d99b782216b6945";
        src = fetchurl {
          url = "https://api.github.com/repos/GrahamCampbell/Result-Type/zipball/3ba905c11371512af9d9bdd27d99b782216b6945";
          sha256 = "16bsycdsgcf4jz2sd277958rn9k9mzxjnby20xpmyhb7s8c2rac7";
        };
      };
    };
    "guzzlehttp/guzzle" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "guzzlehttp-guzzle-d281ed313b989f213357e3be1a179f02196ac99b";
        src = fetchurl {
          url = "https://api.github.com/repos/guzzle/guzzle/zipball/d281ed313b989f213357e3be1a179f02196ac99b";
          sha256 = "048hm3r04ldk2w9pqja6jmkc590h1kln3136128bn7zzdg1vmqi4";
        };
      };
    };
    "guzzlehttp/promises" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "guzzlehttp-promises-f9c436286ab2892c7db7be8c8da4ef61ccf7b455";
        src = fetchurl {
          url = "https://api.github.com/repos/guzzle/promises/zipball/f9c436286ab2892c7db7be8c8da4ef61ccf7b455";
          sha256 = "0xp8slhb6kw9n7i5y6cpbgkc0nkk4gb1lw452kz4fszhk3r1wmgh";
        };
      };
    };
    "guzzlehttp/psr7" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "guzzlehttp-psr7-a70f5c95fb43bc83f07c9c948baa0dc1829bf201";
        src = fetchurl {
          url = "https://api.github.com/repos/guzzle/psr7/zipball/a70f5c95fb43bc83f07c9c948baa0dc1829bf201";
          sha256 = "1xp4c6v1qszbhzdgcgbd03dvxsk0s0vysr3q4rvhm134qlkbrdf2";
        };
      };
    };
    "guzzlehttp/uri-template" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "guzzlehttp-uri-template-ecea8feef63bd4fef1f037ecb288386999ecc11c";
        src = fetchurl {
          url = "https://api.github.com/repos/guzzle/uri-template/zipball/ecea8feef63bd4fef1f037ecb288386999ecc11c";
          sha256 = "0r3cbb2pgsy4nawbylc0nbski2r9dkl335ay5m4i82yglspl9zz4";
        };
      };
    };
    "http-interop/http-factory-guzzle" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "http-interop-http-factory-guzzle-8f06e92b95405216b237521cc64c804dd44c4a81";
        src = fetchurl {
          url = "https://api.github.com/repos/http-interop/http-factory-guzzle/zipball/8f06e92b95405216b237521cc64c804dd44c4a81";
          sha256 = "0pnyagn95a6ngq1a167srqb9qvjsh11xbgzn44ckcwzq61704h9i";
        };
      };
    };
    "laminas/laminas-diactoros" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laminas-laminas-diactoros-143a16306602ce56b8b092a7914fef03c37f9ed2";
        src = fetchurl {
          url = "https://api.github.com/repos/laminas/laminas-diactoros/zipball/143a16306602ce56b8b092a7914fef03c37f9ed2";
          sha256 = "147hfv4xac496yd6mjsqizfaqgdw92ij7cw4fn0qyavar2nwm2jm";
        };
      };
    };
    "laravel/framework" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-framework-599a28196d284fee158cc10086fd56ac625ad7a3";
        src = fetchurl {
          url = "https://api.github.com/repos/laravel/framework/zipball/599a28196d284fee158cc10086fd56ac625ad7a3";
          sha256 = "1r0s4gmz9w3g5hgv33513n6pikayhl1sifja8cdfjpc4i2zgpnf0";
        };
      };
    };
    "laravel/octane" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-octane-b8b11ef25600baa835d364e724f2e948dc1eb88b";
        src = fetchurl {
          url = "https://api.github.com/repos/laravel/octane/zipball/b8b11ef25600baa835d364e724f2e948dc1eb88b";
          sha256 = "1s220pf8k8z0gq61i4r58ljr9533dpwmhl5drfgc0mi07hdh9shv";
        };
      };
    };
    "laravel/prompts" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-prompts-749395fcd5f8f7530fe1f00dfa84eb22c83d94ea";
        src = fetchurl {
          url = "https://api.github.com/repos/laravel/prompts/zipball/749395fcd5f8f7530fe1f00dfa84eb22c83d94ea";
          sha256 = "08il347gnlhh7qvbqxfjwk0i7xzf0rzzp3w4nrqjqgq2vyjvv5na";
        };
      };
    };
    "laravel/scout" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-scout-f40f14b7a63be753a425eae4f56cd71d08478242";
        src = fetchurl {
          url = "https://api.github.com/repos/laravel/scout/zipball/f40f14b7a63be753a425eae4f56cd71d08478242";
          sha256 = "0phx9as843jrjd8q9bbwqvb415fqpdqccir7cszav93xwc88vkla";
        };
      };
    };
    "laravel/serializable-closure" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-serializable-closure-613b2d4998f85564d40497e05e89cb6d9bd1cbe8";
        src = fetchurl {
          url = "https://api.github.com/repos/laravel/serializable-closure/zipball/613b2d4998f85564d40497e05e89cb6d9bd1cbe8";
          sha256 = "1lvqm5xw7q4ym6kffm4jx6viz7jvshmh6692i7nwskz861s1f05n";
        };
      };
    };
    "laravel/tinker" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-tinker-ba4d51eb56de7711b3a37d63aa0643e99a339ae5";
        src = fetchurl {
          url = "https://api.github.com/repos/laravel/tinker/zipball/ba4d51eb56de7711b3a37d63aa0643e99a339ae5";
          sha256 = "1zwfb4qcy254fbfzv0y6vijmr5309qi419mppmzd3x68bhwbqqhx";
        };
      };
    };
    "league/commonmark" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "league-commonmark-d990688c91cedfb69753ffc2512727ec646df2ad";
        src = fetchurl {
          url = "https://api.github.com/repos/thephpleague/commonmark/zipball/d990688c91cedfb69753ffc2512727ec646df2ad";
          sha256 = "139lmk7kr0kapsx3hj3wypmfkrnlwf8k1c9x34k5aqi8hwk1xzyf";
        };
      };
    };
    "league/config" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "league-config-754b3604fb2984c71f4af4a9cbe7b57f346ec1f3";
        src = fetchurl {
          url = "https://api.github.com/repos/thephpleague/config/zipball/754b3604fb2984c71f4af4a9cbe7b57f346ec1f3";
          sha256 = "0yjb85cd0qa0mra995863dij2hmcwk9x124vs8lrwiylb0l3mn8s";
        };
      };
    };
    "league/flysystem" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "league-flysystem-edc1bb7c86fab0776c3287dbd19b5fa278347319";
        src = fetchurl {
          url = "https://api.github.com/repos/thephpleague/flysystem/zipball/edc1bb7c86fab0776c3287dbd19b5fa278347319";
          sha256 = "04pimnf6r8ji528miz1cvzd7wqg3i79nlgrlnk1g9sl58c3aac99";
        };
      };
    };
    "league/flysystem-aws-s3-v3" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "league-flysystem-aws-s3-v3-c6ff6d4606e48249b63f269eba7fabdb584e76a9";
        src = fetchurl {
          url = "https://api.github.com/repos/thephpleague/flysystem-aws-s3-v3/zipball/c6ff6d4606e48249b63f269eba7fabdb584e76a9";
          sha256 = "1xafv6yal257zjs78v08axhx0vh8mwp2c755qcc663aqqxf0f191";
        };
      };
    };
    "league/flysystem-local" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "league-flysystem-local-e0e8d52ce4b2ed154148453d321e97c8e931bd27";
        src = fetchurl {
          url = "https://api.github.com/repos/thephpleague/flysystem-local/zipball/e0e8d52ce4b2ed154148453d321e97c8e931bd27";
          sha256 = "1znrjl38qagn78rjnsrlqmwghff6dfdqk9wy5r0bhrf6yjfs7j3z";
        };
      };
    };
    "league/mime-type-detection" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "league-mime-type-detection-2d6702ff215bf922936ccc1ad31007edc76451b9";
        src = fetchurl {
          url = "https://api.github.com/repos/thephpleague/mime-type-detection/zipball/2d6702ff215bf922936ccc1ad31007edc76451b9";
          sha256 = "0i1gkmflcb17f2bi39xgfgxkjw0wb3qzlag7zjdwqfrg991xda0v";
        };
      };
    };
    "league/uri" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "league-uri-81fb5145d2644324614cc532b28efd0215bda430";
        src = fetchurl {
          url = "https://api.github.com/repos/thephpleague/uri/zipball/81fb5145d2644324614cc532b28efd0215bda430";
          sha256 = "0aszqkywpvclrqw2pdm3chjjidv8k73arcqjdhv078n0yzrlq5ar";
        };
      };
    };
    "league/uri-interfaces" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "league-uri-interfaces-08cfc6c4f3d811584fb09c37e2849e6a7f9b0742";
        src = fetchurl {
          url = "https://api.github.com/repos/thephpleague/uri-interfaces/zipball/08cfc6c4f3d811584fb09c37e2849e6a7f9b0742";
          sha256 = "18fhgrfl3vfnl64pqj4ak2gqg3hzn1vfpsfdaxzppjdyqrvpmr2g";
        };
      };
    };
    "maennchen/zipstream-php" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "maennchen-zipstream-php-aeadcf5c412332eb426c0f9b4485f6accba2a99f";
        src = fetchurl {
          url = "https://api.github.com/repos/maennchen/ZipStream-PHP/zipball/aeadcf5c412332eb426c0f9b4485f6accba2a99f";
          sha256 = "111mmfg696km1wzwmzzxm46cr4d9zkdqa4qz900l98318a5qjl6x";
        };
      };
    };
    "meilisearch/meilisearch-php" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "meilisearch-meilisearch-php-78879c29cb2eb1c9e3cf09707b87d8a369a4579d";
        src = fetchurl {
          url = "https://api.github.com/repos/meilisearch/meilisearch-php/zipball/78879c29cb2eb1c9e3cf09707b87d8a369a4579d";
          sha256 = "00gp6vjpa6csz72niv71rypkps5j1vzfmnn6qbigzhdspg4s777z";
        };
      };
    };
    "monolog/monolog" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "monolog-monolog-aef6ee73a77a66e404dd6540934a9ef1b3c855b4";
        src = fetchurl {
          url = "https://api.github.com/repos/Seldaek/monolog/zipball/aef6ee73a77a66e404dd6540934a9ef1b3c855b4";
          sha256 = "1p926il809sfz64g07x7nfa7a9z5llpvyaxc2gah5shmfg8dza3d";
        };
      };
    };
    "mtdowling/jmespath.php" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "mtdowling-jmespath.php-a2a865e05d5f420b50cc2f85bb78d565db12a6bc";
        src = fetchurl {
          url = "https://api.github.com/repos/jmespath/jmespath.php/zipball/a2a865e05d5f420b50cc2f85bb78d565db12a6bc";
          sha256 = "0jrv7w57fb22lrmvr1llw82g2zghm55bar8mp7jnmx486fn6vlx1";
        };
      };
    };
    "nesbot/carbon" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "nesbot-carbon-129700ed449b1f02d70272d2ac802357c8c30c58";
        src = fetchurl {
          url = "https://api.github.com/repos/CarbonPHP/carbon/zipball/129700ed449b1f02d70272d2ac802357c8c30c58";
          sha256 = "11vwvi92jla5a0im44ycqzmq5b264l2bmcwxh7q9yr6la8p9p13c";
        };
      };
    };
    "nette/schema" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "nette-schema-da801d52f0354f70a638673c4a0f04e16529431d";
        src = fetchurl {
          url = "https://api.github.com/repos/nette/schema/zipball/da801d52f0354f70a638673c4a0f04e16529431d";
          sha256 = "0l9yc070yd90v4bzqrcnl4lc7vsk35d96fs1r8qsy4v8gnwmmfxy";
        };
      };
    };
    "nette/utils" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "nette-utils-736c567e257dbe0fcf6ce81b4d6dbe05c6899f96";
        src = fetchurl {
          url = "https://api.github.com/repos/nette/utils/zipball/736c567e257dbe0fcf6ce81b4d6dbe05c6899f96";
          sha256 = "1v81fswairscrnakbrfh8mlh5i873krlgvhv6ngsb9pi281x6r2b";
        };
      };
    };
    "nikic/php-parser" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "nikic-php-parser-447a020a1f875a434d62f2a401f53b82a396e494";
        src = fetchurl {
          url = "https://api.github.com/repos/nikic/PHP-Parser/zipball/447a020a1f875a434d62f2a401f53b82a396e494";
          sha256 = "036m3siss8wsmqdwnvkhpfl7ayj44sw5nz5jhsdj1zzl96w4f7xa";
        };
      };
    };
    "nunomaduro/termwind" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "nunomaduro-termwind-52915afe6a1044e8b9cee1bcff836fb63acf9cda";
        src = fetchurl {
          url = "https://api.github.com/repos/nunomaduro/termwind/zipball/52915afe6a1044e8b9cee1bcff836fb63acf9cda";
          sha256 = "0bb0c47kckpv2wla8wpp9wqf2zf3ifi0amcrs3kmcfxpcp5ckbkr";
        };
      };
    };
    "php-http/discovery" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "php-http-discovery-82fe4c73ef3363caed49ff8dd1539ba06044910d";
        src = fetchurl {
          url = "https://api.github.com/repos/php-http/discovery/zipball/82fe4c73ef3363caed49ff8dd1539ba06044910d";
          sha256 = "14hhhlysb2z42r7jy3yrqlyickrg252y0y6pd1ss9al2ijrhfdmn";
        };
      };
    };
    "phpoption/phpoption" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpoption-phpoption-e3fac8b24f56113f7cb96af14958c0dd16330f54";
        src = fetchurl {
          url = "https://api.github.com/repos/schmittjoh/php-option/zipball/e3fac8b24f56113f7cb96af14958c0dd16330f54";
          sha256 = "0rbw9mljc00rx2drrqpmwfs47s77iprxvpbff2vqw082x4y989rq";
        };
      };
    };
    "psr/clock" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "psr-clock-e41a24703d4560fd0acb709162f73b8adfc3aa0d";
        src = fetchurl {
          url = "https://api.github.com/repos/php-fig/clock/zipball/e41a24703d4560fd0acb709162f73b8adfc3aa0d";
          sha256 = "0wz5b8hgkxn3jg88cb3901hj71axsj0fil6pwl413igghch6i8kj";
        };
      };
    };
    "psr/container" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "psr-container-c71ecc56dfe541dbd90c5360474fbc405f8d5963";
        src = fetchurl {
          url = "https://api.github.com/repos/php-fig/container/zipball/c71ecc56dfe541dbd90c5360474fbc405f8d5963";
          sha256 = "1mvan38yb65hwk68hl0p7jymwzr4zfnaxmwjbw7nj3rsknvga49i";
        };
      };
    };
    "psr/event-dispatcher" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "psr-event-dispatcher-dbefd12671e8a14ec7f180cab83036ed26714bb0";
        src = fetchurl {
          url = "https://api.github.com/repos/php-fig/event-dispatcher/zipball/dbefd12671e8a14ec7f180cab83036ed26714bb0";
          sha256 = "05nicsd9lwl467bsv4sn44fjnnvqvzj1xqw2mmz9bac9zm66fsjd";
        };
      };
    };
    "psr/http-client" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "psr-http-client-bb5906edc1c324c9a05aa0873d40117941e5fa90";
        src = fetchurl {
          url = "https://api.github.com/repos/php-fig/http-client/zipball/bb5906edc1c324c9a05aa0873d40117941e5fa90";
          sha256 = "1dfyjqj1bs2n2zddk8402v6rjq93fq26hwr0rjh53m11wy1wagsx";
        };
      };
    };
    "psr/http-factory" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "psr-http-factory-2b4765fddfe3b508ac62f829e852b1501d3f6e8a";
        src = fetchurl {
          url = "https://api.github.com/repos/php-fig/http-factory/zipball/2b4765fddfe3b508ac62f829e852b1501d3f6e8a";
          sha256 = "1ll0pzm0vd5kn45hhwrlkw2z9nqysqkykynn1bk1a73c5cjrghx3";
        };
      };
    };
    "psr/http-message" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "psr-http-message-402d35bcb92c70c026d1a6a9883f06b2ead23d71";
        src = fetchurl {
          url = "https://api.github.com/repos/php-fig/http-message/zipball/402d35bcb92c70c026d1a6a9883f06b2ead23d71";
          sha256 = "13cnlzrh344n00sgkrp5cgbkr8dznd99c3jfnpl0wg1fdv1x4qfm";
        };
      };
    };
    "psr/log" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "psr-log-f16e1d5863e37f8d8c2a01719f5b34baa2b714d3";
        src = fetchurl {
          url = "https://api.github.com/repos/php-fig/log/zipball/f16e1d5863e37f8d8c2a01719f5b34baa2b714d3";
          sha256 = "14h8r5qwjvlj7mjwk6ksbhffbv4k9v5cailin9039z1kz4nwz38y";
        };
      };
    };
    "psr/simple-cache" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "psr-simple-cache-764e0b3939f5ca87cb904f570ef9be2d78a07865";
        src = fetchurl {
          url = "https://api.github.com/repos/php-fig/simple-cache/zipball/764e0b3939f5ca87cb904f570ef9be2d78a07865";
          sha256 = "0hgcanvd9gqwkaaaq41lh8fsfdraxmp2n611lvqv69jwm1iy76g8";
        };
      };
    };
    "psy/psysh" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "psy-psysh-d73fa3c74918ef4522bb8a3bf9cab39161c4b57c";
        src = fetchurl {
          url = "https://api.github.com/repos/bobthecow/psysh/zipball/d73fa3c74918ef4522bb8a3bf9cab39161c4b57c";
          sha256 = "0nrkinza27z9l6hfwfay1sn81pnf902zl1aai6y4vpqxvvy4hqra";
        };
      };
    };
    "ralouphie/getallheaders" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "ralouphie-getallheaders-120b605dfeb996808c31b6477290a714d356e822";
        src = fetchurl {
          url = "https://api.github.com/repos/ralouphie/getallheaders/zipball/120b605dfeb996808c31b6477290a714d356e822";
          sha256 = "1bv7ndkkankrqlr2b4kw7qp3fl0dxi6bp26bnim6dnlhavd6a0gg";
        };
      };
    };
    "ramsey/collection" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "ramsey-collection-a4b48764bfbb8f3a6a4d1aeb1a35bb5e9ecac4a5";
        src = fetchurl {
          url = "https://api.github.com/repos/ramsey/collection/zipball/a4b48764bfbb8f3a6a4d1aeb1a35bb5e9ecac4a5";
          sha256 = "0y5s9rbs023sw94yzvxr8fn9rr7xw03f08zmc9n9jl49zlr5s52p";
        };
      };
    };
    "ramsey/uuid" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "ramsey-uuid-91039bc1faa45ba123c4328958e620d382ec7088";
        src = fetchurl {
          url = "https://api.github.com/repos/ramsey/uuid/zipball/91039bc1faa45ba123c4328958e620d382ec7088";
          sha256 = "0n6rj0b042fq319gfnp2c4aawawfz8vb2allw30jjfaf8497hh9j";
        };
      };
    };
    "scrivo/highlight.php" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "scrivo-highlight.php-850f4b44697a2552e892ffe71490ba2733c2fc6e";
        src = fetchurl {
          url = "https://api.github.com/repos/scrivo/highlight.php/zipball/850f4b44697a2552e892ffe71490ba2733c2fc6e";
          sha256 = "1bm1s5nq3h48kaxayg9aihdfr9n034h7415z335jrkgxv305cpw5";
        };
      };
    };
    "spatie/image" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "spatie-image-06cf293f66c833704935ba18e16c784d7e8433a7";
        src = fetchurl {
          url = "https://api.github.com/repos/spatie/image/zipball/06cf293f66c833704935ba18e16c784d7e8433a7";
          sha256 = "0844wia442gb2asc7ipvb2xlg3m4jix8xrsba2mvyqmhy2ncrvkh";
        };
      };
    };
    "spatie/image-optimizer" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "spatie-image-optimizer-4fd22035e81d98fffced65a8c20d9ec4daa9671c";
        src = fetchurl {
          url = "https://api.github.com/repos/spatie/image-optimizer/zipball/4fd22035e81d98fffced65a8c20d9ec4daa9671c";
          sha256 = "0j7sghn5g5jcy6cnhr7f7byxjh8aa3x6w9p81n1kqickbkwpz9gk";
        };
      };
    };
    "spatie/laravel-medialibrary" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "spatie-laravel-medialibrary-8372552a74e781dbcb70ab8b7d0cc9c520b41daa";
        src = fetchurl {
          url = "https://api.github.com/repos/spatie/laravel-medialibrary/zipball/8372552a74e781dbcb70ab8b7d0cc9c520b41daa";
          sha256 = "1v67s5yk8rdsiznhm484jsdnyrhssr8wm788jnfr8lid3k5jir14";
        };
      };
    };
    "spatie/laravel-package-tools" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "spatie-laravel-package-tools-ba67eee37d86ed775dab7dad58a7cbaf9a6cfe78";
        src = fetchurl {
          url = "https://api.github.com/repos/spatie/laravel-package-tools/zipball/ba67eee37d86ed775dab7dad58a7cbaf9a6cfe78";
          sha256 = "02miwcrpmvpdf6382b7yzk0vjzfpypljkdj7rvhqdvcinlhlv9v8";
        };
      };
    };
    "spatie/shiki-php" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "spatie-shiki-php-05cbdd79180fdc71488047c27cfaf73be2b6c5fc";
        src = fetchurl {
          url = "https://api.github.com/repos/spatie/shiki-php/zipball/05cbdd79180fdc71488047c27cfaf73be2b6c5fc";
          sha256 = "0i5bwp0mh9z28853f72a6gzlx4l6chz2qkvizp9jh6ls0jlj5pky";
        };
      };
    };
    "spatie/temporary-directory" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "spatie-temporary-directory-580eddfe9a0a41a902cac6eeb8f066b42e65a32b";
        src = fetchurl {
          url = "https://api.github.com/repos/spatie/temporary-directory/zipball/580eddfe9a0a41a902cac6eeb8f066b42e65a32b";
          sha256 = "04wqsnk15ii8hhp4nxapp3wl3c6lfc9fh5l5pdijqsb16j8y2f5d";
        };
      };
    };
    "symfony/clock" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-clock-b81435fbd6648ea425d1ee96a2d8e68f4ceacd24";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/clock/zipball/b81435fbd6648ea425d1ee96a2d8e68f4ceacd24";
          sha256 = "137ywgyj5n24aprq7z2wkhmzcrqm96awszypikr5m3kgbvjiafg4";
        };
      };
    };
    "symfony/console" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-console-fefcc18c0f5d0efe3ab3152f15857298868dc2c3";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/console/zipball/fefcc18c0f5d0efe3ab3152f15857298868dc2c3";
          sha256 = "017hwcrl6gyf5gpqhz3xzdq0farcfwcb4hswpbh9s6bkgdq2rqka";
        };
      };
    };
    "symfony/css-selector" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-css-selector-601a5ce9aaad7bf10797e3663faefce9e26c24e2";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/css-selector/zipball/601a5ce9aaad7bf10797e3663faefce9e26c24e2";
          sha256 = "1wynlxnm2d65kbv68j0gq2158ybjq1bcka93szhflg16y8dixknw";
        };
      };
    };
    "symfony/deprecation-contracts" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-deprecation-contracts-74c71c939a79f7d5bf3c1ce9f5ea37ba0114c6f6";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/deprecation-contracts/zipball/74c71c939a79f7d5bf3c1ce9f5ea37ba0114c6f6";
          sha256 = "0jr67zcxmgq26xi9lrw3pg33fvchf27qg3liicm3r1k36hg4ymwf";
        };
      };
    };
    "symfony/error-handler" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-error-handler-6150b89186573046167796fa5f3f76601d5145f8";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/error-handler/zipball/6150b89186573046167796fa5f3f76601d5145f8";
          sha256 = "0sjr5z6rv9m22j5lgmlgg803kpwzwkmrhld9wgm3aj24b8k0x3lz";
        };
      };
    };
    "symfony/event-dispatcher" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-event-dispatcher-910c5db85a5356d0fea57680defec4e99eb9c8c1";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/event-dispatcher/zipball/910c5db85a5356d0fea57680defec4e99eb9c8c1";
          sha256 = "1dwigkvzawr9i0wkfgfk4am00nb9fcblrks3s1vpqp67v4yi32xr";
        };
      };
    };
    "symfony/event-dispatcher-contracts" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-event-dispatcher-contracts-7642f5e970b672283b7823222ae8ef8bbc160b9f";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/event-dispatcher-contracts/zipball/7642f5e970b672283b7823222ae8ef8bbc160b9f";
          sha256 = "0d6d95w7dix7l8wyz66ki9781z3k8hsz1c7aglszlc1fn2v9kb93";
        };
      };
    };
    "symfony/finder" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-finder-87a71856f2f56e4100373e92529eed3171695cfb";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/finder/zipball/87a71856f2f56e4100373e92529eed3171695cfb";
          sha256 = "1skvr0z0l3qmwq9a3950fvpcrhnl7cvhpnpbz4brxlyq3czdkr2w";
        };
      };
    };
    "symfony/http-foundation" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-http-foundation-62d1a43796ca3fea3f83a8470dfe63a4af3bc588";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/http-foundation/zipball/62d1a43796ca3fea3f83a8470dfe63a4af3bc588";
          sha256 = "0yr90n4081ljg2fnrgyfvrqfafkal4w4dixr8xcarjb16wqqza45";
        };
      };
    };
    "symfony/http-kernel" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-http-kernel-3c432966bd8c7ec7429663105f5a02d7e75b4306";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/http-kernel/zipball/3c432966bd8c7ec7429663105f5a02d7e75b4306";
          sha256 = "0nr65qmbc4xmjc747cd7yzqga4782n5nrcg5zda2aljrpmwvrma3";
        };
      };
    };
    "symfony/mailer" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-mailer-e4d358702fb66e4c8a2af08e90e7271a62de39cc";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/mailer/zipball/e4d358702fb66e4c8a2af08e90e7271a62de39cc";
          sha256 = "0ypc63pbqnpih6m5v14jhn1micd2qnm9br23r4yn2b4x2l5zn2g1";
        };
      };
    };
    "symfony/mime" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-mime-7f9617fcf15cb61be30f8b252695ed5e2bfac283";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/mime/zipball/7f9617fcf15cb61be30f8b252695ed5e2bfac283";
          sha256 = "0rz42ziyrlp7kjfp1bdr8q1yjj3va43fna7pyqv7ifb2w767y2d3";
        };
      };
    };
    "symfony/polyfill-ctype" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-polyfill-ctype-a3cc8b044a6ea513310cbd48ef7333b384945638";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/polyfill-ctype/zipball/a3cc8b044a6ea513310cbd48ef7333b384945638";
          sha256 = "1gwalz2r31bfqldkqhw8cbxybmc1pkg74kvg07binkhk531gjqdn";
        };
      };
    };
    "symfony/polyfill-intl-grapheme" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-polyfill-intl-grapheme-b9123926e3b7bc2f98c02ad54f6a4b02b91a8abe";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/polyfill-intl-grapheme/zipball/b9123926e3b7bc2f98c02ad54f6a4b02b91a8abe";
          sha256 = "06kbz2rqp0kyxpry055pciv02ihl7vgygigqhdqqy6q7aphg9i9a";
        };
      };
    };
    "symfony/polyfill-intl-idn" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-polyfill-intl-idn-c36586dcf89a12315939e00ec9b4474adcb1d773";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/polyfill-intl-idn/zipball/c36586dcf89a12315939e00ec9b4474adcb1d773";
          sha256 = "1abzqpkq647mh6z5xbf81v50q9s6llaag9sk8y0mf3n0lm47nx4w";
        };
      };
    };
    "symfony/polyfill-intl-normalizer" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-polyfill-intl-normalizer-3833d7255cc303546435cb650316bff708a1c75c";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/polyfill-intl-normalizer/zipball/3833d7255cc303546435cb650316bff708a1c75c";
          sha256 = "0qrq26nw97xfcl0p8x4ria46lk47k73vjjyqiklpw8w5cbibsfxj";
        };
      };
    };
    "symfony/polyfill-mbstring" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-polyfill-mbstring-85181ba99b2345b0ef10ce42ecac37612d9fd341";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/polyfill-mbstring/zipball/85181ba99b2345b0ef10ce42ecac37612d9fd341";
          sha256 = "07ir4drsx4ddmbps6igm6wyrzx2ksz3d61rs2m7p27qz7kx17ff1";
        };
      };
    };
    "symfony/polyfill-php80" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-polyfill-php80-60328e362d4c2c802a54fcbf04f9d3fb892b4cf8";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/polyfill-php80/zipball/60328e362d4c2c802a54fcbf04f9d3fb892b4cf8";
          sha256 = "008nx5xplqx3iks3fpzd4qgy3zzrvx1bmsdc13ndf562a6hf9lrg";
        };
      };
    };
    "symfony/polyfill-php83" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-polyfill-php83-2fb86d65e2d424369ad2905e83b236a8805ba491";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/polyfill-php83/zipball/2fb86d65e2d424369ad2905e83b236a8805ba491";
          sha256 = "1agcx7ydr1ljimacxbgpspcx7kssclwm0bj4zcdq6fhdwrkzxa15";
        };
      };
    };
    "symfony/polyfill-uuid" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-polyfill-uuid-21533be36c24be3f4b1669c4725c7d1d2bab4ae2";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/polyfill-uuid/zipball/21533be36c24be3f4b1669c4725c7d1d2bab4ae2";
          sha256 = "0v8x07llqn7hac6qzm92ly6839ib63v05630rzr71f5ds69j1m09";
        };
      };
    };
    "symfony/process" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-process-d34b22ba9390ec19d2dd966c40aa9e8462f27a7e";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/process/zipball/d34b22ba9390ec19d2dd966c40aa9e8462f27a7e";
          sha256 = "029n4zaqsbcib8y4j4gwjafnb828l74s4qcwzqj56vjdf6pn5w26";
        };
      };
    };
    "symfony/psr-http-message-bridge" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-psr-http-message-bridge-03f2f72319e7acaf2a9f6fcbe30ef17eec51594f";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/psr-http-message-bridge/zipball/03f2f72319e7acaf2a9f6fcbe30ef17eec51594f";
          sha256 = "0da5al65q016y70l8za4p10ypklh8qc3rracjjlv4x44clzm9abc";
        };
      };
    };
    "symfony/routing" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-routing-e10a2450fa957af6c448b9b93c9010a4e4c0725e";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/routing/zipball/e10a2450fa957af6c448b9b93c9010a4e4c0725e";
          sha256 = "01z8r9yryx08j0vw97q4xblk4wa2pa7ya416ddrs25s39cns8imx";
        };
      };
    };
    "symfony/service-contracts" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-service-contracts-e53260aabf78fb3d63f8d79d69ece59f80d5eda0";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/service-contracts/zipball/e53260aabf78fb3d63f8d79d69ece59f80d5eda0";
          sha256 = "0qvk3ajc1jgw97ibr3jmxh7wxmxrvra5471ashhbd56gaiim7iq4";
        };
      };
    };
    "symfony/string" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-string-446e0d146f991dde3e73f45f2c97a9faad773c82";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/string/zipball/446e0d146f991dde3e73f45f2c97a9faad773c82";
          sha256 = "0ad2xspi7yp2631nhzfqvb8lnq71vmhwxm6lhms8zj3p9z7vgvsg";
        };
      };
    };
    "symfony/translation" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-translation-e2674a30132b7cc4d74540d6c2573aa363f05923";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/translation/zipball/e2674a30132b7cc4d74540d6c2573aa363f05923";
          sha256 = "049npvkmg0xrydqqjmxlkrf0vjr80nhhdmzn581xc3qhivhg3xp7";
        };
      };
    };
    "symfony/translation-contracts" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-translation-contracts-4667ff3bd513750603a09c8dedbea942487fb07c";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/translation-contracts/zipball/4667ff3bd513750603a09c8dedbea942487fb07c";
          sha256 = "1hkjg2anfkc56c4k31r2q857pm2w0r57zsn5hfrg7zv47slhb55n";
        };
      };
    };
    "symfony/uid" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-uid-2d294d0c48df244c71c105a169d0190bfb080426";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/uid/zipball/2d294d0c48df244c71c105a169d0190bfb080426";
          sha256 = "16qzg9mzpp7cs56a01i0gskyhjp4f609hjscv6vsnr8xfkjpq4mq";
        };
      };
    };
    "symfony/var-dumper" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-var-dumper-c6a22929407dec8765d6e2b6ff85b800b245879c";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/var-dumper/zipball/c6a22929407dec8765d6e2b6ff85b800b245879c";
          sha256 = "1g13jzzslna9pj5g2gjcq2pb7ddka72vwhmcpfbzl8qwvv8f29fm";
        };
      };
    };
    "tijsverkoyen/css-to-inline-styles" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "tijsverkoyen-css-to-inline-styles-0d72ac1c00084279c1816675284073c5a337c20d";
        src = fetchurl {
          url = "https://api.github.com/repos/tijsverkoyen/CssToInlineStyles/zipball/0d72ac1c00084279c1816675284073c5a337c20d";
          sha256 = "0m1yxpxxk5zdvj6rrqrzmivh6f6c9cpsm00a75ac1divg8bihmzx";
        };
      };
    };
    "ueberdosis/tiptap-php" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "ueberdosis-tiptap-php-640667176da4cdfaa84c32093171e0674c3c807f";
        src = fetchurl {
          url = "https://api.github.com/repos/ueberdosis/tiptap-php/zipball/640667176da4cdfaa84c32093171e0674c3c807f";
          sha256 = "168wd6sviisg95z50gwgwrgvhshd3y25lg738vwl4hvlwsnw0xr8";
        };
      };
    };
    "vlucas/phpdotenv" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "vlucas-phpdotenv-a59a13791077fe3d44f90e7133eb68e7d22eaff2";
        src = fetchurl {
          url = "https://api.github.com/repos/vlucas/phpdotenv/zipball/a59a13791077fe3d44f90e7133eb68e7d22eaff2";
          sha256 = "1w7nyghdx0vw0v3rqzx0x3lafhrkgfk2fi3xiy5vf4lkbv3rdl4h";
        };
      };
    };
    "voku/portable-ascii" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "voku-portable-ascii-b1d923f88091c6bf09699efcd7c8a1b1bfd7351d";
        src = fetchurl {
          url = "https://api.github.com/repos/voku/portable-ascii/zipball/b1d923f88091c6bf09699efcd7c8a1b1bfd7351d";
          sha256 = "1x5wls3q4m7sa0jly8f7s29sd4kb2p59imdr6i5ajzyn5b947aac";
        };
      };
    };
    "webmozart/assert" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "webmozart-assert-11cb2199493b2f8a3b53e7f19068fc6aac760991";
        src = fetchurl {
          url = "https://api.github.com/repos/webmozarts/assert/zipball/11cb2199493b2f8a3b53e7f19068fc6aac760991";
          sha256 = "18qiza1ynwxpi6731jx1w5qsgw98prld1lgvfk54z92b1nc7psix";
        };
      };
    };
  };
  devPackages = {};
in
composerEnv.buildPackage {
  inherit packages devPackages noDev;
  name = "twasgood";
  src = composerEnv.filterSrc ./.;
  executable = false;
  symlinkDependencies = false;
  meta = {
    license = "proprietary";
  };
}
