{
  composerEnv,
  fetchurl,
  fetchgit ? null,
  fetchhg ? null,
  fetchsvn ? null,
  noDev ? false,
}: let
  packages = {
    "archtechx/enums" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "archtechx-enums-475f45e682b0771253707f9403b704759a08da5f";
        src = fetchurl {
          url = "https://api.github.com/repos/archtechx/enums/zipball/475f45e682b0771253707f9403b704759a08da5f";
          sha256 = "1bnqkyfhmn10nlx82r9068f7i2ajznl5192wv3xwk39jadnl63vs";
        };
      };
    };
    "based/momentum-modal" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "based-momentum-modal-1776ce6a86dd1cf9ddea1889ad6d63ebda7756ce";
        src = fetchurl {
          url = "https://api.github.com/repos/lepikhinb/momentum-modal/zipball/1776ce6a86dd1cf9ddea1889ad6d63ebda7756ce";
          sha256 = "0w4049qqywyack93gjs2prnlyz4nfdya461r1pzxwghk5yj52bvk";
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
        name = "carbonphp-carbon-doctrine-types-99f76ffa36cce3b70a4a6abce41dba15ca2e84cb";
        src = fetchurl {
          url = "https://api.github.com/repos/CarbonPHP/carbon-doctrine-types/zipball/99f76ffa36cce3b70a4a6abce41dba15ca2e84cb";
          sha256 = "0vkhwbprqlcg4awdknaycbfydb4spk7vd1v0nxbq06zx22dmphaz";
        };
      };
    };
    "clue/stream-filter" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "clue-stream-filter-049509fef80032cb3f051595029ab75b49a3c2f7";
        src = fetchurl {
          url = "https://api.github.com/repos/clue/stream-filter/zipball/049509fef80032cb3f051595029ab75b49a3c2f7";
          sha256 = "0s6w0rll29nir7q3lc2nlf88qrcy06rx7svpfy80p6p0w35j14yi";
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
    "doctrine/cache" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "doctrine-cache-1ca8f21980e770095a31456042471a57bc4c68fb";
        src = fetchurl {
          url = "https://api.github.com/repos/doctrine/cache/zipball/1ca8f21980e770095a31456042471a57bc4c68fb";
          sha256 = "1p8ia9g3mqz71bv4x8q1ng1fgcidmyksbsli1fjbialpgjk9k1ss";
        };
      };
    };
    "doctrine/dbal" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "doctrine-dbal-d7dc08f98cba352b2bab5d32c5e58f7e745c11a7";
        src = fetchurl {
          url = "https://api.github.com/repos/doctrine/dbal/zipball/d7dc08f98cba352b2bab5d32c5e58f7e745c11a7";
          sha256 = "13xvqvc3gszp6w9ih97dghgjbln7pwhd76s612bdcm5lm6ksgbc2";
        };
      };
    };
    "doctrine/deprecations" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "doctrine-deprecations-dfbaa3c2d2e9a9df1118213f3b8b0c597bb99fab";
        src = fetchurl {
          url = "https://api.github.com/repos/doctrine/deprecations/zipball/dfbaa3c2d2e9a9df1118213f3b8b0c597bb99fab";
          sha256 = "1qydhnf94wgjlrgzydjcz31rr5f87pg3vlkkd0gynggw1ycgkkcg";
        };
      };
    };
    "doctrine/event-manager" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "doctrine-event-manager-b680156fa328f1dfd874fd48c7026c41570b9c6e";
        src = fetchurl {
          url = "https://api.github.com/repos/doctrine/event-manager/zipball/b680156fa328f1dfd874fd48c7026c41570b9c6e";
          sha256 = "135zcwnlfijxzv3x5qn1zs3jmybs1n2q64pbs5gbjwmsdgrxhzsi";
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
    "dragon-code/contracts" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "dragon-code-contracts-44dbad923f152e0dc2699fbac2d33b65dd6a8f7d";
        src = fetchurl {
          url = "https://api.github.com/repos/TheDragonCode/contracts/zipball/44dbad923f152e0dc2699fbac2d33b65dd6a8f7d";
          sha256 = "1gkcflar15sympx7kl06926rgp9wcqfkh9a3ix7q3rlpplxl6rfn";
        };
      };
    };
    "dragon-code/pretty-array" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "dragon-code-pretty-array-6c84e2454491b414efbd37985c322712cdf9012f";
        src = fetchurl {
          url = "https://api.github.com/repos/TheDragonCode/pretty-array/zipball/6c84e2454491b414efbd37985c322712cdf9012f";
          sha256 = "054k0slrb6p7pqqacpixkl789xfvn716fz553084bhc0b1slrxvm";
        };
      };
    };
    "dragon-code/support" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "dragon-code-support-087d7baaa963cdbb24e901dc27e10cdc31c2529c";
        src = fetchurl {
          url = "https://api.github.com/repos/TheDragonCode/support/zipball/087d7baaa963cdbb24e901dc27e10cdc31c2529c";
          sha256 = "06f97m8jyakw86vkpg7z4iym23nc3mwfbcllpz3x89ppm9i38iwq";
        };
      };
    };
    "dragonmantank/cron-expression" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "dragonmantank-cron-expression-adfb1f505deb6384dc8b39804c5065dd3c8c8c0a";
        src = fetchurl {
          url = "https://api.github.com/repos/dragonmantank/cron-expression/zipball/adfb1f505deb6384dc8b39804c5065dd3c8c8c0a";
          sha256 = "1gw2bnsh8ca5plfpyyyz1idnx7zxssg6fbwl7niszck773zrm5ca";
        };
      };
    };
    "egulias/email-validator" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "egulias-email-validator-ebaaf5be6c0286928352e054f2d5125608e5405e";
        src = fetchurl {
          url = "https://api.github.com/repos/egulias/EmailValidator/zipball/ebaaf5be6c0286928352e054f2d5125608e5405e";
          sha256 = "02n4sh0gywqzsl46n9q8hqqgiyva2gj4lxdz9fw4pvhkm1s27wd6";
        };
      };
    };
    "felixdorn/laravel-make-pivot-table" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "felixdorn-laravel-make-pivot-table-f3835d5dc52efe97ce5c541594bae7900ac3f086";
        src = fetchurl {
          url = "https://api.github.com/repos/felixdorn/laravel-make-pivot-table/zipball/f3835d5dc52efe97ce5c541594bae7900ac3f086";
          sha256 = "05l7y6adz98li17bbl135vz2bj4v0c0mhfbapshrc82g0wb74mxk";
        };
      };
    };
    "felixdorn/laravel-navigation" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "felixdorn-laravel-navigation-44cbc9a193571b266845cf5340bee418665c8ea3";
        src = fetchurl {
          url = "https://api.github.com/repos/felixdorn/laravel-navigation/zipball/44cbc9a193571b266845cf5340bee418665c8ea3";
          sha256 = "0rwfhb7jc1s89qkbbi0lr9jqqc7yhy827ishrkdxvkmr7bamdwg5";
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
        name = "guzzlehttp-promises-6ea8dd08867a2a42619d65c3deb2c0fcbf81c8f8";
        src = fetchurl {
          url = "https://api.github.com/repos/guzzle/promises/zipball/6ea8dd08867a2a42619d65c3deb2c0fcbf81c8f8";
          sha256 = "03l91ksymgygdwa30ry0752564nrwkbgmrmlhmmhq89v06i70lln";
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
    "inertiajs/inertia-laravel" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "inertiajs-inertia-laravel-2a1e19048f95c0e4adb2b2733f9119e49c4fc09f";
        src = fetchurl {
          url = "https://api.github.com/repos/inertiajs/inertia-laravel/zipball/2a1e19048f95c0e4adb2b2733f9119e49c4fc09f";
          sha256 = "0zynpg8dnb1knqrsfnmz080pl9s8wg05hc8z6bwa3wzddrf3gy3s";
        };
      };
    };
    "intervention/image" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "intervention-image-04be355f8d6734c826045d02a1079ad658322dad";
        src = fetchurl {
          url = "https://api.github.com/repos/Intervention/image/zipball/04be355f8d6734c826045d02a1079ad658322dad";
          sha256 = "1cbg43hm2jgwb7gm1r9xcr4cpx8ng1zr93zx6shk9xhjlssnv0bx";
        };
      };
    };
    "jean85/pretty-package-versions" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "jean85-pretty-package-versions-f9fdd29ad8e6d024f52678b570e5593759b550b4";
        src = fetchurl {
          url = "https://api.github.com/repos/Jean85/pretty-package-versions/zipball/f9fdd29ad8e6d024f52678b570e5593759b550b4";
          sha256 = "1b7i3zxgpfpvyvqdpdzbykrcmxqsdgn13mhpzm33r4wxazbrh8is";
        };
      };
    };
    "laminas/laminas-diactoros" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laminas-laminas-diactoros-6584d44eb8e477e89d453313b858daac6183cddc";
        src = fetchurl {
          url = "https://api.github.com/repos/laminas/laminas-diactoros/zipball/6584d44eb8e477e89d453313b858daac6183cddc";
          sha256 = "0a53mgy5pdfrs1vrdl8lg28yzhr2bg7q7wdqmzncbpx6xcq5jfzi";
        };
      };
    };
    "laravel-lang/attributes" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-lang-attributes-b60817d0361ec2fe29f100f76cc9bd0c13a36ec9";
        src = fetchurl {
          url = "https://api.github.com/repos/Laravel-Lang/attributes/zipball/b60817d0361ec2fe29f100f76cc9bd0c13a36ec9";
          sha256 = "0c0277c00vkgsnyc46cdfkhc96f8498gagv06n7s9gx9h6l2rdqx";
        };
      };
    };
    "laravel-lang/common" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-lang-common-ce2d52543846052dc79de6d3060044b49545e018";
        src = fetchurl {
          url = "https://api.github.com/repos/Laravel-Lang/common/zipball/ce2d52543846052dc79de6d3060044b49545e018";
          sha256 = "0aw1p6yfvflvxkr5vrq95vimnrcd8sikyyw65p3gzzfksnmfx9iz";
        };
      };
    };
    "laravel-lang/http-statuses" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-lang-http-statuses-0e8b1af2835f951f5587f6c635ea6b929f275415";
        src = fetchurl {
          url = "https://api.github.com/repos/Laravel-Lang/http-statuses/zipball/0e8b1af2835f951f5587f6c635ea6b929f275415";
          sha256 = "064ailq722hdg9bnvgsspxkzchpv92rvblvydxj2vwzg3zcwzgnv";
        };
      };
    };
    "laravel-lang/lang" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-lang-lang-5a6a3e7751a91dec3ee7d69c12db4690643d59a0";
        src = fetchurl {
          url = "https://api.github.com/repos/Laravel-Lang/lang/zipball/5a6a3e7751a91dec3ee7d69c12db4690643d59a0";
          sha256 = "0rqbdf6ivjhdw6yfjabv4xwf9dqhbmrmk39akx1fg0c4iwxsvaz2";
        };
      };
    };
    "laravel-lang/publisher" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-lang-publisher-946405e3d8c7105b0ae8cf8de34a3e6e98a70a84";
        src = fetchurl {
          url = "https://api.github.com/repos/Laravel-Lang/publisher/zipball/946405e3d8c7105b0ae8cf8de34a3e6e98a70a84";
          sha256 = "158mascimdx38d5zhwwln07x5mnl1fq5g8aiqgz37x8jpifnalb5";
        };
      };
    };
    "laravel/framework" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-framework-c4ea52bb044faef4a103d7dd81746c01b2ec860e";
        src = fetchurl {
          url = "https://api.github.com/repos/laravel/framework/zipball/c4ea52bb044faef4a103d7dd81746c01b2ec860e";
          sha256 = "0pzn4w91spsk8cbsg8mps4f564r2lv2llz4nz5chhkc3y08l0kh9";
        };
      };
    };
    "laravel/octane" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-octane-065310f5baec40c61b68eeb8058b041079c3453e";
        src = fetchurl {
          url = "https://api.github.com/repos/laravel/octane/zipball/065310f5baec40c61b68eeb8058b041079c3453e";
          sha256 = "1cn0xn4xwc569rkh0rq87lkqnf5x4lsiz4c8m58vizflc2yry5xy";
        };
      };
    };
    "laravel/prompts" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-prompts-7b4029a84c37cb2725fc7f011586e2997040bc95";
        src = fetchurl {
          url = "https://api.github.com/repos/laravel/prompts/zipball/7b4029a84c37cb2725fc7f011586e2997040bc95";
          sha256 = "0fzww2cdpm5l6smas1kw47wh9j0w72z00bb8ahxyzlz0gl4k7jz8";
        };
      };
    };
    "laravel/sanctum" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-sanctum-8c104366459739f3ada0e994bcd3e6fd681ce3d5";
        src = fetchurl {
          url = "https://api.github.com/repos/laravel/sanctum/zipball/8c104366459739f3ada0e994bcd3e6fd681ce3d5";
          sha256 = "04sq941ylz7h8rm9m3cr2pq9jvj7n7a0ahm9v0m36n1yv3zz5jc5";
        };
      };
    };
    "laravel/scout" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-scout-f9cf4f79163e3c5f13f81369d4992d66e6700502";
        src = fetchurl {
          url = "https://api.github.com/repos/laravel/scout/zipball/f9cf4f79163e3c5f13f81369d4992d66e6700502";
          sha256 = "1sxpxn64lxn0mh2shb1k79abajzznhkpix7bnfkwm314zaql5dmj";
        };
      };
    };
    "laravel/serializable-closure" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-serializable-closure-1dc4a3dbfa2b7628a3114e43e32120cce7cdda9c";
        src = fetchurl {
          url = "https://api.github.com/repos/laravel/serializable-closure/zipball/1dc4a3dbfa2b7628a3114e43e32120cce7cdda9c";
          sha256 = "1pad69bcwxjbd8zadv8pbq73xsgiahv50r2cw047i58wqfgdghby";
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
        name = "league-commonmark-b650144166dfa7703e62a22e493b853b58d874b0";
        src = fetchurl {
          url = "https://api.github.com/repos/thephpleague/commonmark/zipball/b650144166dfa7703e62a22e493b853b58d874b0";
          sha256 = "0ggjlpjdjvk9dxdav2264j7ycazsg6s5wlzmv8ihv375wi20dg5g";
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
        name = "league-flysystem-0adc0d9a51852e170e0028a60bd271726626d3f0";
        src = fetchurl {
          url = "https://api.github.com/repos/thephpleague/flysystem/zipball/0adc0d9a51852e170e0028a60bd271726626d3f0";
          sha256 = "0pm68cjlcywfgfsrnm9zcllvxmsrcqzfpp13dsr6m0r6rna1m7rf";
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
    "meilisearch/meilisearch-php" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "meilisearch-meilisearch-php-e3d8a74fdb0c65ecdef6ef9e89c110810c5c1aa0";
        src = fetchurl {
          url = "https://api.github.com/repos/meilisearch/meilisearch-php/zipball/e3d8a74fdb0c65ecdef6ef9e89c110810c5c1aa0";
          sha256 = "02jsif7pmqgypkxm50v4wvm44lw7609d0jf30rlsl2dqm53ywxl4";
        };
      };
    };
    "monolog/monolog" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "monolog-monolog-f4393b648b78a5408747de94fca38beb5f7e9ef8";
        src = fetchurl {
          url = "https://api.github.com/repos/Seldaek/monolog/zipball/f4393b648b78a5408747de94fca38beb5f7e9ef8";
          sha256 = "0jz5b9rss98xa4bw0y4bp3by9vpbw97scwndkjimq7kwr9n6kpjy";
        };
      };
    };
    "nesbot/carbon" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "nesbot-carbon-afd46589c216118ecd48ff2b95d77596af1e57ed";
        src = fetchurl {
          url = "https://api.github.com/repos/briannesbitt/Carbon/zipball/afd46589c216118ecd48ff2b95d77596af1e57ed";
          sha256 = "17sz76kydaf5n74qgqz36yxbmg4lwcbcv6kpjxrqfqfrb65sz5b6";
        };
      };
    };
    "nette/schema" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "nette-schema-9522dad6211c4d995a01a9ac529da88d0b0ba7b5";
        src = fetchurl {
          url = "https://api.github.com/repos/nette/schema/zipball/9522dad6211c4d995a01a9ac529da88d0b0ba7b5";
          sha256 = "06fcr0l31s32lflwz1siqxbf662im1dqyj0gak5bdgsww0mygrx7";
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
        name = "nikic-php-parser-3abf7425cd284141dc5d8d14a9ee444de3345d1a";
        src = fetchurl {
          url = "https://api.github.com/repos/nikic/PHP-Parser/zipball/3abf7425cd284141dc5d8d14a9ee444de3345d1a";
          sha256 = "0sw9j22d0h6c82ywzpm9nnz2cngv5rj9vh7ivyxqwx984c6r0s1g";
        };
      };
    };
    "nunomaduro/termwind" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "nunomaduro-termwind-8ab0b32c8caa4a2e09700ea32925441385e4a5dc";
        src = fetchurl {
          url = "https://api.github.com/repos/nunomaduro/termwind/zipball/8ab0b32c8caa4a2e09700ea32925441385e4a5dc";
          sha256 = "1g75vpq7014s5yd6bvj78b88ia31slkikdhjv8iprz987qm5dnl7";
        };
      };
    };
    "nyholm/psr7" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "nyholm-psr7-a71f2b11690f4b24d099d6b16690a90ae14fc6f3";
        src = fetchurl {
          url = "https://api.github.com/repos/Nyholm/psr7/zipball/a71f2b11690f4b24d099d6b16690a90ae14fc6f3";
          sha256 = "08vmmw9fxiqkd4i4in2iibgnpr2m958y555551gz2rs20lzxf78d";
        };
      };
    };
    "php-http/client-common" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "php-http-client-common-0cfe9858ab9d3b213041b947c881d5b19ceeca46";
        src = fetchurl {
          url = "https://api.github.com/repos/php-http/client-common/zipball/0cfe9858ab9d3b213041b947c881d5b19ceeca46";
          sha256 = "1y6mkz0l0xd7iqjf6f91xzkfs2d3ic3a1vb6jdhnnb6cqjn6wp1k";
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
    "php-http/httplug" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "php-http-httplug-5cad731844891a4c282f3f3e1b582c46839d22f4";
        src = fetchurl {
          url = "https://api.github.com/repos/php-http/httplug/zipball/5cad731844891a4c282f3f3e1b582c46839d22f4";
          sha256 = "01c12l2ni615715z1g59m15vb93b53pn2myscs4dlikgcqmh1s1v";
        };
      };
    };
    "php-http/message" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "php-http-message-06dd5e8562f84e641bf929bfe699ee0f5ce8080a";
        src = fetchurl {
          url = "https://api.github.com/repos/php-http/message/zipball/06dd5e8562f84e641bf929bfe699ee0f5ce8080a";
          sha256 = "03yvx02xkmn76vhgxs1jwa5ycdz3fsql3yaahhqz6ygsxwmbjq0s";
        };
      };
    };
    "php-http/message-factory" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "php-http-message-factory-4d8778e1c7d405cbb471574821c1ff5b68cc8f57";
        src = fetchurl {
          url = "https://api.github.com/repos/php-http/message-factory/zipball/4d8778e1c7d405cbb471574821c1ff5b68cc8f57";
          sha256 = "038fgijv9z8mvn8cgqh90zk3gnar823bh07bbk5ynqmq2pwvzcib";
        };
      };
    };
    "php-http/promise" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "php-http-promise-fc85b1fba37c169a69a07ef0d5a8075770cc1f83";
        src = fetchurl {
          url = "https://api.github.com/repos/php-http/promise/zipball/fc85b1fba37c169a69a07ef0d5a8075770cc1f83";
          sha256 = "195r1wy4nf44hg5d5mdbhpfmvbns0whf54q4l89ygr3anvk69blv";
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
    "psr/cache" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "psr-cache-aa5030cfa5405eccfdcb1083ce040c2cb8d253bf";
        src = fetchurl {
          url = "https://api.github.com/repos/php-fig/cache/zipball/aa5030cfa5405eccfdcb1083ce040c2cb8d253bf";
          sha256 = "07rnyjwb445sfj30v5ny3gfsgc1m7j7cyvwjgs2cm9slns1k1ml8";
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
        name = "psr-http-message-cb6ce4845ce34a8ad9e68117c10ee90a29919eba";
        src = fetchurl {
          url = "https://api.github.com/repos/php-fig/http-message/zipball/cb6ce4845ce34a8ad9e68117c10ee90a29919eba";
          sha256 = "1s87sajxsxl30ciqyhx0vir2pai63va4ssbnq7ki6s050i4vm80h";
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
        name = "psy-psysh-2fd717afa05341b4f8152547f142cd2f130f6818";
        src = fetchurl {
          url = "https://api.github.com/repos/bobthecow/psysh/zipball/2fd717afa05341b4f8152547f142cd2f130f6818";
          sha256 = "009mhfsh6vsrygdmr5b64w8mppw6j2n8ajbx856dpcwjji8fx8q7";
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
    "sentry/sdk" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sentry-sdk-24c235ff2027401cbea099bf88689e1a1f197c7a";
        src = fetchurl {
          url = "https://api.github.com/repos/getsentry/sentry-php-sdk/zipball/24c235ff2027401cbea099bf88689e1a1f197c7a";
          sha256 = "04va7097d40f1g7iadfbqv2jjvv72vacvkm2jz4vdid4cx1dmw10";
        };
      };
    };
    "sentry/sentry" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sentry-sentry-8859631ba5ab15bc1af420b0eeed19ecc6c9d81d";
        src = fetchurl {
          url = "https://api.github.com/repos/getsentry/sentry-php/zipball/8859631ba5ab15bc1af420b0eeed19ecc6c9d81d";
          sha256 = "1d2zy68hfp7dzdp5mnc67i05k7in8rs69pl07i43z879pz1kdd3d";
        };
      };
    };
    "sentry/sentry-laravel" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sentry-sentry-laravel-1293e5732f8405e12f000cdf5dee78c927a18de0";
        src = fetchurl {
          url = "https://api.github.com/repos/getsentry/sentry-laravel/zipball/1293e5732f8405e12f000cdf5dee78c927a18de0";
          sha256 = "0hcc73frvp5970xrhb25qrq1gl60mx8rblq9pavml1y9np6kpaay";
        };
      };
    };
    "spatie/shiki-php" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "spatie-shiki-php-dc2305e2f96420219b741c70df86d6f452f15688";
        src = fetchurl {
          url = "https://api.github.com/repos/spatie/shiki-php/zipball/dc2305e2f96420219b741c70df86d6f452f15688";
          sha256 = "0qvg56q43wss6pwlmxlkw5y18rhsx4hg79344kxfz35fafmapdaz";
        };
      };
    };
    "symfony/console" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-console-72d080eb9edf80e36c19be61f72c98ed8273b765";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/console/zipball/72d080eb9edf80e36c19be61f72c98ed8273b765";
          sha256 = "1gwgrhxk066lbqqvgh49zdm81jfs05dc3d05mczb3c6m1yqlrw75";
        };
      };
    };
    "symfony/css-selector" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-css-selector-1c7cee86c6f812896af54434f8ce29c8d94f9ff4";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/css-selector/zipball/1c7cee86c6f812896af54434f8ce29c8d94f9ff4";
          sha256 = "114jy3i0vx33wgngifcv2d848cv068pcxqlzc55fjd9r4k392rzy";
        };
      };
    };
    "symfony/deprecation-contracts" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-deprecation-contracts-0e0d29ce1f20deffb4ab1b016a7257c4f1e789a1";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/deprecation-contracts/zipball/0e0d29ce1f20deffb4ab1b016a7257c4f1e789a1";
          sha256 = "1qhyyfyd7q75nyqivjzrljmqa5qhh09gjs2vz7s3xadq0j525c2b";
        };
      };
    };
    "symfony/error-handler" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-error-handler-231f1b2ee80f72daa1972f7340297d67439224f0";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/error-handler/zipball/231f1b2ee80f72daa1972f7340297d67439224f0";
          sha256 = "0bdphr8xv4d9ln3yiaajzxfvybc6kvcpsybf69kg6f2v88p14pj7";
        };
      };
    };
    "symfony/event-dispatcher" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-event-dispatcher-9fa7f7a21beb22a39a8f3f28618b29e50d7a55a7";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/event-dispatcher/zipball/9fa7f7a21beb22a39a8f3f28618b29e50d7a55a7";
          sha256 = "08yg8qdwin657v66bxw008n05x9zvqw4xnxpxda8dn3rlvzqkvkn";
        };
      };
    };
    "symfony/event-dispatcher-contracts" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-event-dispatcher-contracts-8f93aec25d41b72493c6ddff14e916177c9efc50";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/event-dispatcher-contracts/zipball/8f93aec25d41b72493c6ddff14e916177c9efc50";
          sha256 = "1ybpwhcf82fpa7lj5n2i8jhba2qmq4850svd4nv3v852vwr98ani";
        };
      };
    };
    "symfony/finder" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-finder-d7eb6daf8cd7e9ac4976e9576b32042ef7253453";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/finder/zipball/d7eb6daf8cd7e9ac4976e9576b32042ef7253453";
          sha256 = "1ycj0294v8nh47g34i091aym7wqvbhvgvrl14ilmzym9g2y4h36f";
        };
      };
    };
    "symfony/http-client" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-http-client-abca35865118edf35a23f2f24978a1784c831cb4";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/http-client/zipball/abca35865118edf35a23f2f24978a1784c831cb4";
          sha256 = "0w5kvmxwscmawcsqmjs3wr6awki25knw8nf8flvny1zal7akdkjg";
        };
      };
    };
    "symfony/http-client-contracts" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-http-client-contracts-20414d96f391677bf80078aa55baece78b82647d";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/http-client-contracts/zipball/20414d96f391677bf80078aa55baece78b82647d";
          sha256 = "0p69zmsgy7m2hmsjbqammjx2kxsl901n1xrww475cgakg1i8kaws";
        };
      };
    };
    "symfony/http-foundation" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-http-foundation-133ac043875f59c26c55e79cf074562127cce4d2";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/http-foundation/zipball/133ac043875f59c26c55e79cf074562127cce4d2";
          sha256 = "044g2c5si87s2x3ni3ls77b29pvaqznh8kyzpcbwnnrc8azbsk6g";
        };
      };
    };
    "symfony/http-kernel" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-http-kernel-96df83d51b5f78804f70c093b97310794fd6257b";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/http-kernel/zipball/96df83d51b5f78804f70c093b97310794fd6257b";
          sha256 = "1n1mycw0ww0i8n214lxbx7b6jyq446l2b0kp21bmg6yg0vqw96d1";
        };
      };
    };
    "symfony/mailer" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-mailer-b6a25408c569ae2366b3f663a4edad19420a9c26";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/mailer/zipball/b6a25408c569ae2366b3f663a4edad19420a9c26";
          sha256 = "1424bzyxaib2956dwsyv6n3h3r7ymsz0wb8pr1qbrxnjak2svd2f";
        };
      };
    };
    "symfony/mime" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-mime-abe16ee7790b16aa525877419deb0f113953f0e1";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/mime/zipball/abe16ee7790b16aa525877419deb0f113953f0e1";
          sha256 = "0x2alq3h585s5wvljcladfbvs9s56xfcr65n9xqwfnkladabqlwd";
        };
      };
    };
    "symfony/options-resolver" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-options-resolver-47aa818121ed3950acd2b58d1d37d08a94f9bf55";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/options-resolver/zipball/47aa818121ed3950acd2b58d1d37d08a94f9bf55";
          sha256 = "07hldqa33vjmnr6l9x7x8mss5vxh9zil3vbfc7bc7lb66mbz0lnj";
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
    "symfony/polyfill-php81" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-polyfill-php81-4a4cfc2d253c21a5ad0e53071df248ed48c6ce5c";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/polyfill-php81/zipball/4a4cfc2d253c21a5ad0e53071df248ed48c6ce5c";
          sha256 = "01s1x2ak9c3idpigbdx7y6a9h2mfplh53131z0mr48wh9azn2s5q";
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
        name = "symfony-process-3f94e5f13ff58df371a7ead461b6e8068900fbb3";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/process/zipball/3f94e5f13ff58df371a7ead461b6e8068900fbb3";
          sha256 = "0jmfaqwm9107jbbkcc2bkrx15sy6jdd5y8v4vq3qx65y9i2x0fn9";
        };
      };
    };
    "symfony/psr-http-message-bridge" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-psr-http-message-bridge-581ca6067eb62640de5ff08ee1ba6850a0ee472e";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/psr-http-message-bridge/zipball/581ca6067eb62640de5ff08ee1ba6850a0ee472e";
          sha256 = "1x9zyp5kmr1vdb457varl32bsr34j8ibcj1hd5kn5601wx6b1hf5";
        };
      };
    };
    "symfony/routing" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-routing-a7c8036bd159486228dc9be3e846a00a0dda9f9f";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/routing/zipball/a7c8036bd159486228dc9be3e846a00a0dda9f9f";
          sha256 = "0ilz7g2qlh2rsc3cgwbmyi0057d8hrgbq2p8cna7i7pzpn3h7drx";
        };
      };
    };
    "symfony/service-contracts" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-service-contracts-bd1d9e59a81d8fa4acdcea3f617c581f7475a80f";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/service-contracts/zipball/bd1d9e59a81d8fa4acdcea3f617c581f7475a80f";
          sha256 = "1q7382ingrvqdh7hm8lrwrimcvlv5qcmp6xrparfh1kmrsf45prv";
        };
      };
    };
    "symfony/string" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-string-d66f9c343fa894ec2037cc928381df90a7ad4306";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/string/zipball/d66f9c343fa894ec2037cc928381df90a7ad4306";
          sha256 = "0mrpipmvzfp7qdvz5ijv9c06v1bjisn2lkqsmlyyq1zg37ahbl8p";
        };
      };
    };
    "symfony/translation" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-translation-cf8360b8352b086be620fae8342c4d96e391a489";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/translation/zipball/cf8360b8352b086be620fae8342c4d96e391a489";
          sha256 = "1mml373h8xlaabf3bfm5phdnvrl4rgb6xywqx7ph0i4j98g1i5z3";
        };
      };
    };
    "symfony/translation-contracts" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-translation-contracts-b9d2189887bb6b2e0367a9fc7136c5239ab9b05a";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/translation-contracts/zipball/b9d2189887bb6b2e0367a9fc7136c5239ab9b05a";
          sha256 = "0y9dp08gw7rk50i5lpci6n2hziajvps97g9j3sz148p0afdr5q3c";
        };
      };
    };
    "symfony/uid" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-uid-2f16054e0a9b194b8ca581d4a64eee3f7d4a9d4d";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/uid/zipball/2f16054e0a9b194b8ca581d4a64eee3f7d4a9d4d";
          sha256 = "0yidks00dzf1ffh7p8323yj3j6pr9bjh1i2cap547g309zhw4kyr";
        };
      };
    };
    "symfony/var-dumper" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-var-dumper-ee14c8254a480913268b1e3b1cba8045ed122694";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/var-dumper/zipball/ee14c8254a480913268b1e3b1cba8045ed122694";
          sha256 = "17zqccbw5inwifw76cirn6w9qrmav9qdfyjis5irkalf5vmhp4vv";
        };
      };
    };
    "tightenco/ziggy" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "tightenco-ziggy-939576ad0f3d3e633a9401c8c377bc7bc873ff35";
        src = fetchurl {
          url = "https://api.github.com/repos/tighten/ziggy/zipball/939576ad0f3d3e633a9401c8c377bc7bc873ff35";
          sha256 = "05z6i6vl1xgq88k0shk0x4d4k3n6famfqz6cw6x58krw17504rz4";
        };
      };
    };
    "tijsverkoyen/css-to-inline-styles" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "tijsverkoyen-css-to-inline-styles-83ee6f38df0a63106a9e4536e3060458b74ccedb";
        src = fetchurl {
          url = "https://api.github.com/repos/tijsverkoyen/CssToInlineStyles/zipball/83ee6f38df0a63106a9e4536e3060458b74ccedb";
          sha256 = "1ahj49c7qz6m3y65jd18cz2c8cg6zqhkmnsrqrw1bf3s8ly9a9bp";
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
        name = "voku-portable-ascii-b56450eed252f6801410d810c8e1727224ae0743";
        src = fetchurl {
          url = "https://api.github.com/repos/voku/portable-ascii/zipball/b56450eed252f6801410d810c8e1727224ae0743";
          sha256 = "0gwlv1hr6ycrf8ik1pnvlwaac8cpm8sa1nf4d49s8rp4k2y5anyl";
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
  devPackages = {
    "brianium/paratest" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "brianium-paratest-64fcfd0e28a6b8078a19dbf9127be2ee645b92ec";
        src = fetchurl {
          url = "https://api.github.com/repos/paratestphp/paratest/zipball/64fcfd0e28a6b8078a19dbf9127be2ee645b92ec";
          sha256 = "1bjk553b06a2lk1f3kd6w070vjdmp466hmc9lxpsxrfhha0ac7c0";
        };
      };
    };
    "fakerphp/faker" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "fakerphp-faker-bfb4fe148adbf78eff521199619b93a52ae3554b";
        src = fetchurl {
          url = "https://api.github.com/repos/FakerPHP/Faker/zipball/bfb4fe148adbf78eff521199619b93a52ae3554b";
          sha256 = "0iv7a1r7n2js07dl9xvc9v3x3nvln4z7i6pmlgyvz1lj3czyfmqm";
        };
      };
    };
    "fidry/cpu-core-counter" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "fidry-cpu-core-counter-8520451a140d3f46ac33042715115e290cf5785f";
        src = fetchurl {
          url = "https://api.github.com/repos/theofidry/cpu-core-counter/zipball/8520451a140d3f46ac33042715115e290cf5785f";
          sha256 = "1yram9rjinh6p8g3b7w12wa0n29jmbfyzbp1vhr2y0px1qfwm5gi";
        };
      };
    };
    "filp/whoops" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "filp-whoops-befcdc0e5dce67252aa6322d82424be928214fa2";
        src = fetchurl {
          url = "https://api.github.com/repos/filp/whoops/zipball/befcdc0e5dce67252aa6322d82424be928214fa2";
          sha256 = "1v78q8xb6jf8wkjnbhnd9idr89m3xqm7d2a9b9d3vza93m3a3d9a";
        };
      };
    };
    "hamcrest/hamcrest-php" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "hamcrest-hamcrest-php-8c3d0a3f6af734494ad8f6fbbee0ba92422859f3";
        src = fetchurl {
          url = "https://api.github.com/repos/hamcrest/hamcrest-php/zipball/8c3d0a3f6af734494ad8f6fbbee0ba92422859f3";
          sha256 = "1ixmmpplaf1z36f34d9f1342qjbcizvi5ddkjdli6jgrbla6a6hr";
        };
      };
    };
    "laravel/breeze" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-breeze-22c53b84b7fff91b01a318d71a10dfc251e92849";
        src = fetchurl {
          url = "https://api.github.com/repos/laravel/breeze/zipball/22c53b84b7fff91b01a318d71a10dfc251e92849";
          sha256 = "1nbplxmqxd4qqdjirl3zxpb45cqghxysc0a85hnsayyznmwa0fgg";
        };
      };
    };
    "laravel/pint" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "laravel-pint-35c00c05ec43e6b46d295efc0f4386ceb30d50d9";
        src = fetchurl {
          url = "https://api.github.com/repos/laravel/pint/zipball/35c00c05ec43e6b46d295efc0f4386ceb30d50d9";
          sha256 = "1znyhqcs7b2d3wqs40z8v915mixpv67wfc2gyb1c116s27asa32z";
        };
      };
    };
    "mockery/mockery" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "mockery-mockery-1f4efdd7d3beafe9807b08156dfcb176d18f1699";
        src = fetchurl {
          url = "https://api.github.com/repos/mockery/mockery/zipball/1f4efdd7d3beafe9807b08156dfcb176d18f1699";
          sha256 = "1vdmk2yp8kg8lhf78p3dnqgfii5zks56viabv84javdpm9zqah6k";
        };
      };
    };
    "myclabs/deep-copy" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "myclabs-deep-copy-3a6b9a42cd8f8771bd4295d13e1423fa7f3d942c";
        src = fetchurl {
          url = "https://api.github.com/repos/myclabs/DeepCopy/zipball/3a6b9a42cd8f8771bd4295d13e1423fa7f3d942c";
          sha256 = "1aa2j8gdy9bdkzmigv81vl42jqyfl19508k13kmsbsncd2zhkvyp";
        };
      };
    };
    "nunomaduro/collision" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "nunomaduro-collision-49ec67fa7b002712da8526678abd651c09f375b2";
        src = fetchurl {
          url = "https://api.github.com/repos/nunomaduro/collision/zipball/49ec67fa7b002712da8526678abd651c09f375b2";
          sha256 = "1gc87x7bgmds5cr721gzsm1j15qbn7y5ghrxx2zrwbp1qdls6afn";
        };
      };
    };
    "nunomaduro/larastan" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "nunomaduro-larastan-340badd89b0eb5bddbc503a4829c08cf9a2819d7";
        src = fetchurl {
          url = "https://api.github.com/repos/larastan/larastan/zipball/340badd89b0eb5bddbc503a4829c08cf9a2819d7";
          sha256 = "1szlvmrsaphapssmc5kk4gz38gv1y4qm2dm32yc5n5ki1abbapv1";
        };
      };
    };
    "pestphp/pest" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "pestphp-pest-b13acb630df52c06123588d321823c31fc685545";
        src = fetchurl {
          url = "https://api.github.com/repos/pestphp/pest/zipball/b13acb630df52c06123588d321823c31fc685545";
          sha256 = "0v74lj4abzjd19gcddh31fz6xqpz51gayck2h16bv5k2rxfasgbb";
        };
      };
    };
    "pestphp/pest-plugin" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "pestphp-pest-plugin-e05d2859e08c2567ee38ce8b005d044e72648c0b";
        src = fetchurl {
          url = "https://api.github.com/repos/pestphp/pest-plugin/zipball/e05d2859e08c2567ee38ce8b005d044e72648c0b";
          sha256 = "03ak0gv3i06c5a5dgfy94qbpjagh1zqqs34fzdzzvr5r0d9faynw";
        };
      };
    };
    "pestphp/pest-plugin-arch" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "pestphp-pest-plugin-arch-d23b2d7498475354522c3818c42ef355dca3fcda";
        src = fetchurl {
          url = "https://api.github.com/repos/pestphp/pest-plugin-arch/zipball/d23b2d7498475354522c3818c42ef355dca3fcda";
          sha256 = "14i1bsv87yzlpmbkiinda4jzmgvrxj1c1x17jc6046yibwbfccqv";
        };
      };
    };
    "pestphp/pest-plugin-laravel" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "pestphp-pest-plugin-laravel-53df51169a7f9595e06839cce638c73e59ace5e8";
        src = fetchurl {
          url = "https://api.github.com/repos/pestphp/pest-plugin-laravel/zipball/53df51169a7f9595e06839cce638c73e59ace5e8";
          sha256 = "18v3x9d7lk954qfkssbjafibxrdig488sh9xgjb8vvgdhcyx04sx";
        };
      };
    };
    "phar-io/manifest" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phar-io-manifest-54750ef60c58e43759730615a392c31c80e23176";
        src = fetchurl {
          url = "https://api.github.com/repos/phar-io/manifest/zipball/54750ef60c58e43759730615a392c31c80e23176";
          sha256 = "0xas0i7jd6w4hknfmbwdswpzngblm3d884hy3rba0q2cs928ndml";
        };
      };
    };
    "phar-io/version" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phar-io-version-4f7fd7836c6f332bb2933569e566a0d6c4cbed74";
        src = fetchurl {
          url = "https://api.github.com/repos/phar-io/version/zipball/4f7fd7836c6f332bb2933569e566a0d6c4cbed74";
          sha256 = "0mdbzh1y0m2vvpf54vw7ckcbcf1yfhivwxgc9j9rbb7yifmlyvsg";
        };
      };
    };
    "phpdocumentor/reflection-common" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpdocumentor-reflection-common-1d01c49d4ed62f25aa84a747ad35d5a16924662b";
        src = fetchurl {
          url = "https://api.github.com/repos/phpDocumentor/ReflectionCommon/zipball/1d01c49d4ed62f25aa84a747ad35d5a16924662b";
          sha256 = "1wx720a17i24471jf8z499dnkijzb4b8xra11kvw9g9hhzfadz1r";
        };
      };
    };
    "phpdocumentor/reflection-docblock" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpdocumentor-reflection-docblock-9d07b3f7fdcf5efec5d1609cba3c19c5ea2bdc9c";
        src = fetchurl {
          url = "https://api.github.com/repos/phpDocumentor/ReflectionDocBlock/zipball/9d07b3f7fdcf5efec5d1609cba3c19c5ea2bdc9c";
          sha256 = "1238xs7wpv4fm3dplshnk8difqxgz5qkj9m9n2cdf2qv8w1kld2p";
        };
      };
    };
    "phpdocumentor/type-resolver" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpdocumentor-type-resolver-153ae662783729388a584b4361f2545e4d841e3c";
        src = fetchurl {
          url = "https://api.github.com/repos/phpDocumentor/TypeResolver/zipball/153ae662783729388a584b4361f2545e4d841e3c";
          sha256 = "1m934q8ydb4kr1akcask1d8db4ap560zmk534phz0s9862fj5cqi";
        };
      };
    };
    "phpmyadmin/sql-parser" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpmyadmin-sql-parser-91d980ab76c3f152481e367f62b921adc38af451";
        src = fetchurl {
          url = "https://api.github.com/repos/phpmyadmin/sql-parser/zipball/91d980ab76c3f152481e367f62b921adc38af451";
          sha256 = "1k4cb0430w439sf8m8k943ppd4cqfyb4v9aygdh67d4z7xf28dq9";
        };
      };
    };
    "phpstan/phpdoc-parser" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpstan-phpdoc-parser-6ca22b154efdd9e3c68c56f5d94670920a1c19a4";
        src = fetchurl {
          url = "https://api.github.com/repos/phpstan/phpdoc-parser/zipball/6ca22b154efdd9e3c68c56f5d94670920a1c19a4";
          sha256 = "05qnrql98fczryqjqk9qhz6dsd3lrqc0s0g5sjl93sgvzs117n74";
        };
      };
    };
    "phpstan/phpstan" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpstan-phpstan-dc4d2f145a88ea7141ae698effd64d9df46527ae";
        src = fetchurl {
          url = "https://api.github.com/repos/phpstan/phpstan/zipball/dc4d2f145a88ea7141ae698effd64d9df46527ae";
          sha256 = "0pyz768nrs2kmcwmqh423knvw6zmcarhn85wpqbgvzqr6si8kiig";
        };
      };
    };
    "phpunit/php-code-coverage" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpunit-php-code-coverage-7e308268858ed6baedc8704a304727d20bc07c77";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/php-code-coverage/zipball/7e308268858ed6baedc8704a304727d20bc07c77";
          sha256 = "1a9m2lp41qm2b2jg1s3im5pdm8f35c3l4b7a0x6j160mkmyb8jc2";
        };
      };
    };
    "phpunit/php-file-iterator" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpunit-php-file-iterator-a95037b6d9e608ba092da1b23931e537cadc3c3c";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/php-file-iterator/zipball/a95037b6d9e608ba092da1b23931e537cadc3c3c";
          sha256 = "1cxdrmvffx6zicjq41hs93jzwzr536vpk9b9vx6cpbyz08v3bbgj";
        };
      };
    };
    "phpunit/php-invoker" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpunit-php-invoker-f5e568ba02fa5ba0ddd0f618391d5a9ea50b06d7";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/php-invoker/zipball/f5e568ba02fa5ba0ddd0f618391d5a9ea50b06d7";
          sha256 = "16hdigfcwzynbnrs29ha7l1pjr81rf2510jx3z3nhmgz9fys7jsl";
        };
      };
    };
    "phpunit/php-text-template" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpunit-php-text-template-0c7b06ff49e3d5072f057eb1fa59258bf287a748";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/php-text-template/zipball/0c7b06ff49e3d5072f057eb1fa59258bf287a748";
          sha256 = "083gkd6rp4zdyh1y8cmplrpfcfa0brn4vmgbcillgsjxxs25pkcs";
        };
      };
    };
    "phpunit/php-timer" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpunit-php-timer-e2a2d67966e740530f4a3343fe2e030ffdc1161d";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/php-timer/zipball/e2a2d67966e740530f4a3343fe2e030ffdc1161d";
          sha256 = "02skpc6b31lgqnjxsh8x3b4mvr6pz8zp5672dllgfknf70byzy1f";
        };
      };
    };
    "phpunit/phpunit" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpunit-phpunit-c1f736a473d21957ead7e94fcc029f571895abf5";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/phpunit/zipball/c1f736a473d21957ead7e94fcc029f571895abf5";
          sha256 = "0n8gqqv2rbg82hvz8yng40r470s9wnmysdr1b54zy5isfzn70ch6";
        };
      };
    };
    "sebastian/cli-parser" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-cli-parser-c34583b87e7b7a8055bf6c450c2c77ce32a24084";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/cli-parser/zipball/c34583b87e7b7a8055bf6c450c2c77ce32a24084";
          sha256 = "0wz2mddfyk2pq8nxl6vji4rba671z6m0xgd80jirik717wcjl9jf";
        };
      };
    };
    "sebastian/code-unit" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-code-unit-a81fee9eef0b7a76af11d121767abc44c104e503";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/code-unit/zipball/a81fee9eef0b7a76af11d121767abc44c104e503";
          sha256 = "0k480x92974k4w2nvaf19xz3brwmjvh84h4wya4xp8vn5a6p3gfg";
        };
      };
    };
    "sebastian/code-unit-reverse-lookup" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-code-unit-reverse-lookup-5e3a687f7d8ae33fb362c5c0743794bbb2420a1d";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/code-unit-reverse-lookup/zipball/5e3a687f7d8ae33fb362c5c0743794bbb2420a1d";
          sha256 = "03x25cyiivl8mf4bgk22c2ivdkh3q7sh59nhivjag2rpnylsj8gb";
        };
      };
    };
    "sebastian/comparator" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-comparator-2d3e04c3b4c1e84a5e7382221ad8883c8fbc4f53";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/comparator/zipball/2d3e04c3b4c1e84a5e7382221ad8883c8fbc4f53";
          sha256 = "13g0c5jxab9hh778h8sp8l12vqf2wm3z2qi6s5rs7nqbp5jihbbs";
        };
      };
    };
    "sebastian/complexity" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-complexity-68ff824baeae169ec9f2137158ee529584553799";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/complexity/zipball/68ff824baeae169ec9f2137158ee529584553799";
          sha256 = "0cpbnmvia2zvnny174gfg8q2i6r3gmhhhh8qlzgasck0zfrv4y5h";
        };
      };
    };
    "sebastian/diff" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-diff-c41e007b4b62af48218231d6c2275e4c9b975b2e";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/diff/zipball/c41e007b4b62af48218231d6c2275e4c9b975b2e";
          sha256 = "0aisnxicr3wbr51ycbcyd32mvh7hw28w3yq2jc0c4qig1xbdbwcc";
        };
      };
    };
    "sebastian/environment" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-environment-8074dbcd93529b357029f5cc5058fd3e43666984";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/environment/zipball/8074dbcd93529b357029f5cc5058fd3e43666984";
          sha256 = "07qzbivf10qs2c6vvyl83szk5iig690cign4wcf182lk6qnfgsmc";
        };
      };
    };
    "sebastian/exporter" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-exporter-955288482d97c19a372d3f31006ab3f37da47adf";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/exporter/zipball/955288482d97c19a372d3f31006ab3f37da47adf";
          sha256 = "0j75qiiacnlrksna7x9x8vazg769jr4wib1c7srwgmr0q6jdfsbd";
        };
      };
    };
    "sebastian/global-state" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-global-state-987bafff24ecc4c9ac418cab1145b96dd6e9cbd9";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/global-state/zipball/987bafff24ecc4c9ac418cab1145b96dd6e9cbd9";
          sha256 = "116vs035nz4qacjfm9zh729ai5f29fvlqr0jpb3majaxr9gjk54g";
        };
      };
    };
    "sebastian/lines-of-code" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-lines-of-code-856e7f6a75a84e339195d48c556f23be2ebf75d0";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/lines-of-code/zipball/856e7f6a75a84e339195d48c556f23be2ebf75d0";
          sha256 = "01jlnxir7il82w1qf2nz9476mv11vhfp97sms93fy8pyk40m3j8k";
        };
      };
    };
    "sebastian/object-enumerator" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-object-enumerator-202d0e344a580d7f7d04b3fafce6933e59dae906";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/object-enumerator/zipball/202d0e344a580d7f7d04b3fafce6933e59dae906";
          sha256 = "1gqlp8dkjgm9zsbklk7rwc3d9nf3mqws6l445vls2q2h6a9j37w1";
        };
      };
    };
    "sebastian/object-reflector" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-object-reflector-24ed13d98130f0e7122df55d06c5c4942a577957";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/object-reflector/zipball/24ed13d98130f0e7122df55d06c5c4942a577957";
          sha256 = "0imfh72b7yjgjnyfh2zrjsfqznz0c6hcsvmp4igmn4cb3w3vpbpv";
        };
      };
    };
    "sebastian/recursion-context" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-recursion-context-05909fb5bc7df4c52992396d0116aed689f93712";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/recursion-context/zipball/05909fb5bc7df4c52992396d0116aed689f93712";
          sha256 = "1dr3wsyx3s5kanlg4s9qgn35wbjjrmhycp31n3azqskalp4whzy5";
        };
      };
    };
    "sebastian/type" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-type-462699a16464c3944eefc02ebdd77882bd3925bf";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/type/zipball/462699a16464c3944eefc02ebdd77882bd3925bf";
          sha256 = "0g2im923glz133bbkz3r12i2n1zpk7d7198znzcms6cs99v6b6mc";
        };
      };
    };
    "sebastian/version" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-version-c51fa83a5d8f43f1402e3f32a005e6262244ef17";
        src = fetchurl {
          url = "https://api.github.com/repos/sebastianbergmann/version/zipball/c51fa83a5d8f43f1402e3f32a005e6262244ef17";
          sha256 = "14cirib9q5r4nn5cvyv3hba07qvpw4dwdnsiz67c3rf4ghjwgfym";
        };
      };
    };
    "spatie/backtrace" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "spatie-backtrace-1a9a145b044677ae3424693f7b06479fc8c137a9";
        src = fetchurl {
          url = "https://api.github.com/repos/spatie/backtrace/zipball/1a9a145b044677ae3424693f7b06479fc8c137a9";
          sha256 = "018x1npg3g7l40czakd1ahxka9w4g4vslrr62xd412v60czarfxh";
        };
      };
    };
    "spatie/error-solutions" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "spatie-error-solutions-ae7393122eda72eed7cc4f176d1e96ea444f2d67";
        src = fetchurl {
          url = "https://api.github.com/repos/spatie/error-solutions/zipball/ae7393122eda72eed7cc4f176d1e96ea444f2d67";
          sha256 = "1x12q8sdi3dr1yak9yj1n5masmjg4vna7fgc3c0y0azv2i3b55rl";
        };
      };
    };
    "spatie/flare-client-php" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "spatie-flare-client-php-180f8ca4c0d0d6fc51477bd8c53ce37ab5a96122";
        src = fetchurl {
          url = "https://api.github.com/repos/spatie/flare-client-php/zipball/180f8ca4c0d0d6fc51477bd8c53ce37ab5a96122";
          sha256 = "0s02y05gmnkah99jqhs0a5lzj3bgs4glaz5dp8l18wq168abb90a";
        };
      };
    };
    "spatie/ignition" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "spatie-ignition-e3a68e137371e1eb9edc7f78ffa733f3b98991d2";
        src = fetchurl {
          url = "https://api.github.com/repos/spatie/ignition/zipball/e3a68e137371e1eb9edc7f78ffa733f3b98991d2";
          sha256 = "1jwj6wjn58ii6g2ggqh72qbgz9155nnar3v8ry2d896wl0biavda";
        };
      };
    };
    "spatie/laravel-ignition" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "spatie-laravel-ignition-3c067b75bfb50574db8f7e2c3978c65eed71126c";
        src = fetchurl {
          url = "https://api.github.com/repos/spatie/laravel-ignition/zipball/3c067b75bfb50574db8f7e2c3978c65eed71126c";
          sha256 = "1kgcfrqsakj7xk0s9v32v6mf77qr8hx82x1p9kj6r5942xfnaccg";
        };
      };
    };
    "ta-tikoma/phpunit-architecture-test" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "ta-tikoma-phpunit-architecture-test-89f0dea1cb0f0d5744d3ec1764a286af5e006636";
        src = fetchurl {
          url = "https://api.github.com/repos/ta-tikoma/phpunit-architecture-test/zipball/89f0dea1cb0f0d5744d3ec1764a286af5e006636";
          sha256 = "1ybkb8a03fl668ls0wlr3ym04i2lymwvdvk7j3js4wywhgwzzfb4";
        };
      };
    };
    "theseer/tokenizer" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "theseer-tokenizer-737eda637ed5e28c3413cb1ebe8bb52cbf1ca7a2";
        src = fetchurl {
          url = "https://api.github.com/repos/theseer/tokenizer/zipball/737eda637ed5e28c3413cb1ebe8bb52cbf1ca7a2";
          sha256 = "1pi1wlzmyzla2wli0h3kqf8vhddhqra2bkp9rg81b38pbh791w34";
        };
      };
    };
  };
in
  composerEnv.buildPackage {
    inherit packages devPackages noDev;
    name = "twasgood-something-else";
    src = composerEnv.filterSrc ./.;
    executable = false;
    symlinkDependencies = false;
    composerExtraArgs = "--no-scripts";
    meta = {
      license = "proprietary";
    };
  }
