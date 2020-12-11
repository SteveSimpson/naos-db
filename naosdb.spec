Summary: Naos DB addon for Nagios
Name:    naosdb
Version: 1.2
Release: 5
License: MIT
URL:	https://github.com/SteveSimpson/naos-db
Vendor: Parsons

Source0: naosdb.tgz
Source1: naosdb_vendor.tgz
# Source2: vautour-style.tgz
# Source3: secdev_naosdb.tgz

%description
Provides simple DB for Nagios. Also adds updated vautour-style GUI for Nagios.

Requires: php >= 7
Requires: php-common, php-xml, php-cli
Requires: php-mbstring, php-json, php-pdo
Requires: nagios
Requires: httpd
BuildRequires: nagios

%define __find_requires %{nil}
Autoreq: 0
BuildArch: noarch
AutoReqProv: no
BuildRoot: %{_tmppath}/%{name}-%{version}-%{release}-%(%{__id_u})


%prep 
umask 0022
%setup -n naosdb -b 0 -a 1 
#-a 2 -a 3


%build
# change the menu
# sed -i.bak "s|menu.html|naos.php?r=nagios%2Fmenu|" vautour-style/index.php
# sed -i.bak "s|menu.html|naos.php?r=nagios%2Fmenu|" vautour-style/index.html

# change the vatour logo to HWSS Text
# sed -i.bak 's|<img src="images/interface/logo.gif" alt="Logo" />|HWSS|' vautour-style/top.html


%install
umask 0022

mkdir -p $RPM_BUILD_ROOT/etc/httpd/conf.d
mkdir -p $RPM_BUILD_ROOT/etc/nagios
mkdir -p $RPM_BUILD_ROOT/var/www/naosdb
mkdir -p $RPM_BUILD_ROOT/var/www/naosdb/web/assets
mkdir -p $RPM_BUILD_ROOT/var/www/naosdb/runtime
mkdir -p $RPM_BUILD_ROOT/var/www/html

for SUBDIR in assets commands config controllers mail migrations models views web widgets yii2_docs vendor
do
  cp -a $SUBDIR  $RPM_BUILD_ROOT/var/www/naosdb/
done

for TARGET in db dev_ip mailer params
do
  mv $RPM_BUILD_ROOT/var/www/naosdb/config/$TARGET.php.sample $RPM_BUILD_ROOT/var/www/naosdb/config/$TARGET.php
done

for TARGET in LICENSE README.md yii
do
  cp $TARGET $RPM_BUILD_ROOT/var/www/naosdb/
done

for TARGET in index.php mb.jpg robots.txt style.css
do
  cp splash/$TARGET $RPM_BUILD_ROOT/var/www/html/
done

cp naosdb.conf         $RPM_BUILD_ROOT/etc/httpd/conf.d/
cp selinux/naosdb.pp                $RPM_BUILD_ROOT/etc/nagios/naosdb.pp

mv $RPM_BUILD_ROOT/var/www/naosdb/yii2_docs $RPM_BUILD_ROOT/var/www/naosdb/vendor_docs
/bin/rm -f $RPM_BUILD_ROOT/var/www/naosdb/web/index-test.php
/bin/rm -f $RPM_BUILD_ROOT/var/www/naosdb/web/index.php
/bin/rm -f $RPM_BUILD_ROOT/var/www/naosdb/web/.htaccess
/bin/rm -f $RPM_BUILD_ROOT/var/www/naosdb/web/robots.txt
/bin/rm -f $RPM_BUILD_ROOT/var/www/naosdb/config/test.php

for TARGET in images js stylesheets
do
  cp -a vautour-style/$TARGET $RPM_BUILD_ROOT/var/www/naosdb/web/
done
# cp vautour-style/*html     $RPM_BUILD_ROOT/var/www/naosdb/web/
cp vautour-style/index.php $RPM_BUILD_ROOT/var/www/naosdb/web/
cp vautour-style/readme.txt $RPM_BUILD_ROOT/var/www/naosdb/vendor_docs/vautour-style-readme.txt

### Vautour Style
# simply builds on the default nagios template
# so here we link to the files that it does not inlcude
pushd $RPM_BUILD_ROOT/var/www/naosdb/web/

## html files
for TARGET in graph-header histogram-form histogram-graph histogram histogram-links infobox jsonquery map-directive map-form map-links map-popup trends-form trends-graph trends-host-yaxis trends trends-links trends-service-yaxis 
do 
  ln -s /usr/share/nagios/html/$TARGET.html .
done

## whole directories
for TARGET in angularjs bootstrap-3.3.7 contexthelp d3 docs includes media spin ssi
do
  ln -s /usr/share/nagios/html/$TARGET .
done

## php files
for TARGET in config.inc main map side
do 
  ln -s /usr/share/nagios/html/$TARGET.php .
done

pushd images
# gifs
for TARGET in action-graph action-nagios action-orig empty graph splunk1 plunk2
do 
  ln -s /usr/share/nagios/html/images/$TARGET.gif .
done

#pngs
for TARGET in globe-support-150x150 histogram logofullsize menu Nagios-clearbg NagiosEnterprises-whitebg-112x46 redudancy redundancy sblogo sflogo trendshot trendssvc weblogo1
do 
  ln -s /usr/share/nagios/html/images/$TARGET.png .
done

ln -s /usr/share/nagios/html/images/logos .
# popd for images
popd

pushd js
for TARGET in histogram-events histogram jsonquery map nagios-decorations trends-form histogram-form map-directive nagios-time trends-graph histogram-graph map-form nag_funcs trends
do 
  ln -s /usr/share/nagios/html/js/$TARGET.js .
done
# simple hack to update jquery without rebuilding Nagios
ln -s jquery-3.5.1.min.js jquery-1.12.4.min.js

# popd for js
popd

pushd stylesheets
ln -s /usr/share/nagios/html/stylesheets/jsonquery.css .
ln -s /usr/share/nagios/html/stylesheets/nag_funcs.css .
# popd for stylesheets
popd

# popd for $RPM_BUILD_ROOT/var/www/naosdb/web/
popd


%clean
# rm -rf $RPM_BUILD_ROOT


%post
if [ ! -f /var/www/naosdb/config/cookiestring ] ; then
  touch /var/www/naosdb/config/cookiestring
  chown 48:48 /var/www/naosdb/config/cookiestring
  chmod 660 /var/www/naosdb/config/cookiestring
  openssl rand -base64 32 > /var/www/naosdb/config/cookiestring
  chmod 440 /var/www/naosdb/config/cookiestring
fi
semodule -i /etc/nagios/naosdb.pp


%files
%defattr(0644,root,root,0755)
%doc /var/www/naosdb/LICENSE
%doc /var/www/naosdb/README.md
%doc /var/www/naosdb/vendor_docs/
/var/www/naosdb/assets
/var/www/naosdb/commands
# /var/www/naosdb/config
/var/www/naosdb/controllers
/var/www/naosdb/mail
/var/www/naosdb/migrations
/var/www/naosdb/models
/var/www/naosdb/vendor
/var/www/naosdb/views
/var/www/naosdb/web/*.html
/var/www/naosdb/web/*.ico
/var/www/naosdb/web/*.php
/var/www/naosdb/web/angularjs
/var/www/naosdb/web/bootstrap-3.3.7
/var/www/naosdb/web/contexthelp
/var/www/naosdb/web/css
/var/www/naosdb/web/d3
/var/www/naosdb/web/docs
/var/www/naosdb/web/images
/var/www/naosdb/web/includes
/var/www/naosdb/web/js
/var/www/naosdb/web/media
/var/www/naosdb/web/nag
/var/www/naosdb/web/spin
/var/www/naosdb/web/ssi
/var/www/naosdb/web/stylesheets
/var/www/naosdb/widgets
/var/www/html/index.php
%config /var/www/html/robots.txt
/var/www/html/style.css
/var/www/html/mb.jpg

%defattr(0755,root,root,0755)
/var/www/naosdb/yii

%defattr(0640,root,apache,0755)
%config /etc/httpd/conf.d/naosdb.conf
%config /var/www/naosdb/config/console.php
%config /var/www/naosdb/config/web.php
%config(noreplace) /var/www/naosdb/config/db.php
%config(noreplace) /var/www/naosdb/config/dev_ip.php
%config(noreplace) /var/www/naosdb/config/mailer.php
%config(noreplace) /var/www/naosdb/config/params.php
/etc/nagios/naosdb.pp

%defattr(0660,apache,apache,0770)
%dir /var/www/naosdb/web/assets
%dir /var/www/naosdb/runtime

%changelog
* Fri Dec 11 2020 Steve Simpson <steven.simpson@parsons.com> - 1.2-5
- Update Naos to use yii paths

* Tue Dec 08 2020 Steve Simpson <steven.simpson@parsons.com> - 1.2-3
- Clean up

* Fri Dec 04 2020 Steve Simpson <steven.simpson@parsons.com> - 1.2-2
- Update yii
- Separate menu items for Service Problems and Updates

* Fri Sep 25 2020 Steve Simpson <steven.simpson@parsons.com> - 1.2-1
- Updated to include vautour style
- CVE fix for jquery

* Thu Feb 13 2020 Steve Simpson <steven.simpson@parsons.com> - 1.1-1
- Updated from upstream to include hardware and software lists

* Wed Nov 20 2019 Steve Simpson <steven.simpson@parsons.com> - 1.0-9
- Updated from upstream for PPS & /etc/hosts

* Fri Oct 11 2019 Steve Simpson <steven.simpson@parsons.com> - 1.0-7
- Updated from upstream

* Wed Oct 9 2019 Steve Simpson <steven.simpson@parsons.com> - 1.0-6
- Updated with SELINUX policy file

* Fri Sep 27 2019 Steve Simpson <steven.simpson@parsons.com> - 1.0-5
- initial rpmbuild
