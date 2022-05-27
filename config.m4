# This is a PHP extension config.m4 file for building pdo_sqlrelay.
# See also https://php.uz/manual/en/internals2.buildsys.configunix.php
# And a fully worked out example php extension in C++ here
# https://stackoverflow.com/questions/25994400/modifying-a-php-extension-creating-makefile-to-include-c-classes-and-co
# See https://www.php.net/manual/en/install.pecl.phpize.php
#
# To use this file to build the extension, with php-devel, it is a one-liner to bash.
#
# phpize --clean; phpize; ./configure; make clean; make; make test
#
# The only thing that might fail is the make test, because you must modify the Makefile
# to include the loading of -d "extension=/usr/lib64/php/modules/pdo.so"
#
# This has been tested with the rudiments-devel and sqlrelay-devel packages loaded
# from the sqlrelay 1.8.0 release. But any sqlrelay newer release should work.
# The files in src/ were taken from the sqlrelay master branch
# due to the PHP 8.1 support.
# This has been tested with PHP 7.4, PHP 8.0 and PHP 8.1
# built and tested in suitable docker containers.

PHP_ARG_ENABLE(pdo_sqlrelay, whether to enable PDO SQLRelay Extension support,
[ --enable-pdo_sqlrelay   Enable PDO SQLRelay Extension support])

if test "$PHP_PDO_SQLRELAY" = "yes"; then
 	AC_DEFINE(HAVE_PDO_SQLRELAY, 1, [Whether you have PDO SQLRelay Extension])
        PHP_REQUIRE_CXX()
	PHP_SUBST(PDO_SQLRELAY_SHARED_LIBADD)
        PHP_ADD_INCLUDE(/wayfair/pkg/firstworks/include)
        PHP_ADD_INCLUDE(src)
        PHP_ADD_LIBRARY_WITH_PATH(rudiments, /wayfair/pkg/firstworks/lib64, PDO_SQLRELAY_SHARED_LIBADD)
        PHP_ADD_LIBRARY_WITH_PATH(sqlrclient, /wayfair/pkg/firstworks/lib64, PDO_SQLRELAY_SHARED_LIBADD)
        # These defined are due to the fact that sqlrelay config.h is not available outside a sqlrelay build.
        AC_DEFINE(SQLR_VERSION, "1.8.1", [used in PHP_MINFO_FUNCTION])
        AC_DEFINE(SQL_RELAY, "SQL Relay", [used in PHP_MINFO_FUNCTION])
	# This is a rudiments backward compatibility patch.
        AC_DEFINE(listnode, singlylinkedlistnode, [needed to back-port to 1.8.0])
        # These would have come from the sqlrelay config.h.in transformation during configure
        # into config.h, and have to do with the status of definitions in pdo_php.h
        # But we can hardwire them due to the stability of PDO at this point.
        AC_DEFINE(HAVE_PHP_PDO_PARAM_ZVAL, 1, [usually from running sqlrelay/configure])
        AC_DEFINE(HAVE_PHP_PDO_ATTR_EMULATE_PREPARES, 1, [usually from running sqlrelay/configure])
        AC_DEFINE(HAVE_PHP_PDO_CONST_ZEND_FUNCTION_ENTRY, 1, [usually from running sqlrelay/configure])
        #
	PHP_NEW_EXTENSION(pdo_sqlrelay, src/pdo_sqlrelay.cpp, $ext_shared)
fi

PHP_ARG_ENABLE(gcov, whether to include gcov symbols,
[ --enable-gcov   Enable GCOV code coverage (requires LTP) - FOR DEVELOPERS ONLY!!], no, no)

if test "$PHP_GCOV" = "yes"; then

  if test "$GCC" != "yes"; then
    AC_MSG_ERROR([GCC is required for --enable-gcov])
  fi

  dnl Check if ccache is being used
  case `$php_shtool path $CC` in
    *ccache*[)] gcc_ccache=yes;;
    *[)] gcc_ccache=no;;
  esac

  if test "$gcc_ccache" = "yes" && (test -z "$CCACHE_DISABLE" || test "$CCACHE_DISABLE" != "1"); then
    AC_MSG_ERROR([ccache must be disabled when --enable-gcov option is used. You can disable ccache by setting environment variable CCACHE_DISABLE=1.])
  fi

  dnl min: 1.5 (i.e. 105, major * 100 + minor for easier comparison)
  ltp_version_min="105"
  dnl non-working versions, e.g. "1.8 1.18";
  dnl remove "none" when introducing the first incompatible LTP version and
  dnl separate any following additions by spaces
  ltp_version_exclude="1.8"

  AC_CHECK_PROG(LTP, lcov, lcov)
  AC_CHECK_PROG(LTP_GENHTML, genhtml, genhtml)
  PHP_SUBST(LTP)
  PHP_SUBST(LTP_GENHTML)

  if test "$LTP"; then
    AC_CACHE_CHECK([for ltp version], php_cv_ltp_version, [
      php_cv_ltp_version=invalid
      ltp_version_vars=`$LTP -v 2>/dev/null | $SED -e 's/^.* //' -e 's/\./ /g' | tr -d a-z`
      if test -n "$ltp_version_vars"; then
        set $ltp_version_vars
        ltp_version="${1}.${2}"
        ltp_version_num="`expr ${1} \* 100 + ${2}`"
        if test $ltp_version_num -ge $ltp_version_min; then
          php_cv_ltp_version="$ltp_version (ok)"
          for ltp_check_version in $ltp_version_exclude; do
            if test "$ltp_version" = "$ltp_check_version"; then
              php_cv_ltp_version=invalid
              break
            fi
          done
        fi
      fi
    ])
  else
    ltp_msg="To enable code coverage reporting you must have LTP installed"
    AC_MSG_ERROR([$ltp_msg])
  fi

  case $php_cv_ltp_version in
    ""|invalid[)]
      ltp_msg="This LTP version is not supported (found: $ltp_version, min: $ltp_version_min, excluded: $ltp_version_exclude)."
      AC_MSG_ERROR([$ltp_msg])
      LTP="exit 0;"
      ;;
  esac

  if test -z "$LTP_GENHTML"; then
    AC_MSG_ERROR([Could not find genhtml from the LTP package])
  fi

  PHP_ADD_MAKEFILE_FRAGMENT($abs_srcdir/Makefile.gcov, $abs_srcdir)

  dnl Remove all optimization flags from CFLAGS
  changequote({,})
  CFLAGS=`echo "$CFLAGS" | $SED -e 's/-O[0-9s]*//g'`
  CXXFLAGS=`echo "$CXXFLAGS" | $SED -e 's/-O[0-9s]*//g'`
  changequote([,])

  dnl Add the special gcc flags
  CFLAGS="$CFLAGS -O0 -fprofile-arcs -ftest-coverage"
  CXXFLAGS="$CXXFLAGS -O0 -fprofile-arcs -ftest-coverage"
fi
