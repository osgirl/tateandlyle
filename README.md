## **Local Development Environment:**

Requirements:

* At least 4 GB RAM (higher is better)

* Stable Broadband Internet Connection, Preferably Wired connection, only during first time drupalvm Installation.

* **Versions**: *Make sure you're running the latest releases of Vagrant, VirtualBox, and Ansible (Installation steps are provided later in this document.)—as of February 2016, Drupal VM recommends: Vagrant 1.8.5, VirtualBox 5.1.x, and Ansible 2.1.x.*

**Fork** Drupalvm Repo from 

* **https://github.com/jayakrishnanj/dvm or **

* **https://github.com/geerlingguy/drupal-vm **

    * If forked from geerlingguy, then create config.yml file and *.make.yml file or composer file to setup the default d8 instance and to select other softwares.

Step 1:

* mkdir ~/projects

* mkdir -p ~/Sites/dvm (To sync the www folder between host and guest)

* cd ~/projects/

* git clone git@github.com:<your_forked_dvm_repo_name>/dvm.git

* git remote -v

    * origin git@github.com:<your_forked_dvm_repo_name>/dvm.git (fetch)

    * origin git@github.com:<your_forked_dvm_repo_name>/dvm.git (push)

Step 2:

* Install Ansible For Mac:

    * sudo easy_install pip

    * sudo pip install ansible

        * Check ansible version via "ansible-playbook —version"

        * sudo ansible-galaxy install -r provisioning/requirements.yml —force

* cd ~/projects/dvm

* vagrant up

* Wait for few minutes for ansible to download roles and software to complete.

* If you see similar to below message, your drupalvm is setup sucessfully.

PLAY RECAP *********************************************************************

dvm                        : ok=241  changed=45   unreachable=0    failed=0

==> dvm: Configuring cache buckets…

* cd ~/Sites/dvm

* ls -la to see 'drupal' is present or not(If Not, run the vagrant up again).

* Common problems and solutions:

    * **Problem:**

        * Permission denied for **"/Users/<mac_username>/.ansible_galaxy"**

        * Solution:** **sudo chown <mac_username>:staff /Users/<mac_username>/.ansible_galaxy

    * **Problem:**

        * --limit @/Users/<mac_username>/projects/dvm/provisioning/playbook.retry

TASK [arknoll.selenium : run] **************************************************

fatal: [dvm]: FAILED! => {"changed": false, "failed": true, "msg": "Error when trying to enable selenium: rc=1 selenium.service is not a native service, redirecting to systemd-sysv-install\nExecuting /lib/systemd/systemd-sysv-install enable selenium\ninsserv: warning: script 'selenium' missing LSB tags and overrides\nupdate-rc.d: error: selenium Default-Start contains no runlevels, aborting.\n"}

**NO MORE HOSTS LEFT *******************************************************************

        * Solution: Try running 'vagrant halt && vagrant up && vagrant provision'

If you face any failure in between , try to rerun the "halt,up and provision" commands, if you still face any issues, try destroying vagrant and create again via "vagrant destroy && vagrant up && vagrant provision"

## **To setup the project inside your drupal vm:**

### Add your new dvm's ssh key into Git Repo:

	ssh-keygen -t rsa -b 4096 -C "<your_email_id>"

 	eval "$(ssh-agent -s)"

   	ssh-add ~/.ssh/id_rsa

	cat < ~/.ssh/id_rsa.pub

Copy the key and paste into your github account [https://github.com/settings/keys](https://github.com/settings/keys)

### Initial Setup and Onboarding:

Follow the onboarding document in [http://blt.readthedocs.io/en/latest/readme/onboarding/](http://blt.readthedocs.io/en/latest/readme/onboarding/)

Below are the procedure for example by following the document.

	Fork the Project Repo git@github.com:acquia-pso/tateandlyle.git

git clone git@github.com:<your_username>/tateandlyle.git
git remote add upstream git@github.com:acquia-pso/tateandlyle.git

git checkout master

### Setup the Virtual Host:

Add below code in your /etc/apache2/sites-enabled/vhosts.conf

<VirtualHost *:80>

  ServerName tal.local

  ServerAlias www.tal.local

  DocumentRoot /var/www/dvm/tateandlyle/docroot

  <Directory "/var/www/dvm/tateandlyle/docroot">

    AllowOverride All

    Options -Indexes +FollowSymLinks

    Require all granted

  </Directory>

  ProxyPassMatch ^/(.*\.php(/.*)?)$ "fcgi://127.0.0.1:9000/var/www/dvm/tateandlyle/docroot"

</VirtualHost>

Restart apache "sudo /etc/init.d/apache2 restart"

### Create database

	echo "Create database tateandlyle;" | mysql -uroot -proot

	

### Setup the Portal:

cd /var/www/dvm/tateandlyle

composer install -vvv —profile

composer blt-alias

	source /home/vagrant/.bashrc

	blt -l 

blt setup:settings

* Add your DB credentials in

    * /var/www/dvm/tateandlyle/docroot/sites/default/settings/local.settings.php

* Check your drush URL aliases in

    * /var/www/dvm/tateandlyle/docroot/sites/default/local.drushrc.php

### Setup Drush Alias:

Create and edit your local drush alias file. Copy drush/site-aliases/example.local.aliases.drushrc.php to drush/site-aliases/local.aliases.drushrc.php. Edit the new alias file with your local path.

Example:

$aliases['tal.local'] = array(

 'uri' => 'tal.local',

 'root' => '/var/www/dvm/tateandlyle/docroot',

 'path-aliases' => array(

   '%dump-dir' => '/tmp',
 ),

);

### Complete the setup:

Run : 'blt local:setup'

Add your project url in mac host file ‘/etc/hosts’

sudo vim /etc/hosts

	Add "192.168.99.99   tal.local" in end of the line.

Restart or reload vagrant by running 

vagrant halt && vagrant up or  vagrant reload

Now, access the project via 'http://tal.local' in your browser.

* You should see ‘**Welcome to Tate and Lyle**’

* If you see default drupal instance similar to dvm.dev , then reload vagrant and try again.

