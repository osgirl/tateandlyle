**Local Development Environment:**

Requirements:

- At least 4 GB RAM (higher is better)
- Stable Broadband Internet Connection, Preferably Wired connection, only during first time drupalvm Installation.
- **Versions** : _Make sure you&#39;re running the latest releases of Vagrant, VirtualBox, and Ansible (Installation steps are provided later in this document.)—as of February 2016, Drupal VM recommends: Vagrant 1.8.5, VirtualBox 5.1.x, and Ansible 2.1.x._

**Fork** Drupalvm Repo from

- **https://github.com/jayakrishnanj/dvm or**
- **https://github.com/geerlingguy/drupal-vm**
  - If forked from geerlingguy, then create config.yml file and \*.make.yml file or composer file to setup the default d8 instance and to select other softwares.

Step 1:

- mkdir ~/projects
- mkdir -p ~/Sites/dvm (To sync the www folder between host and guest)
- cd ~/projects/
- git clone git@github.com:&lt;your\_forked\_dvm\_repo\_name&gt;/dvm.git
- git remote -v
  - rigin git@github.com:&lt;your\_forked\_dvm\_repo\_name&gt;/dvm.git (fetch)
  - rigin git@github.com:&lt;your\_forked\_dvm\_repo\_name&gt;/dvm.git (push)

Step 2:

- Install Ansible For Mac:
  - sudo easy\_install pip
  - sudo pip install ansible
    - ■■Check ansible version via &quot;ansible-playbook —version&quot;
    - ■■sudo ansible-galaxy install -r provisioning/requirements.yml —force
- cd ~/projects/dvm
- vagrant up
- Wait for few minutes for ansible to download roles and software to complete.
- If you see similar to below message, your drupalvm is setup sucessfully.

PLAY RECAP \*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*

dvm                        : ok=241  changed=45   unreachable=0    failed=0

==&gt; dvm:Configuring cache buckets…

- cd ~/Sites/dvm
- ls -la to see &#39;drupal&#39; is present or not(If Not, run the vagrant up again).

- Common problems and solutions:
  - **Problem:**
    - ■■Permission denied for **&quot;/Users/&lt;mac\_username&gt;/.ansible\_galaxy&quot;**
    - ■■Solution:sudo chown &lt;mac\_username&gt;:staff /Users/&lt;mac\_username&gt;/.ansible\_galaxy
  - **Problem:**
    - ■■--limit @/Users/&lt;mac\_username&gt;/projects/dvm/provisioning/playbook.retry
    - ■■

TASK [arknoll.selenium : run]\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*

fatal:[dvm]: FAILED!=&gt;{&quot;changed&quot;:false,&quot;failed&quot;:true,&quot;msg&quot;:&quot;Error when trying to enable selenium: rc=1 selenium.service is not a native service, redirecting to systemd-sysv-install\nExecuting /lib/systemd/systemd-sysv-install enable selenium\ninsserv: warning: script &#39;selenium&#39; missing LSB tags and overrides\nupdate-rc.d: error: selenium Default-Start contains no runlevels, aborting.\n&quot;}

**NO MORE HOSTS LEFT**  **\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\***

-
  -
    - ■■Solution: Try running &#39;vagrant halt &amp;&amp; vagrant up &amp;&amp; vagrant provision&#39;

If you face any failure in between ,try to rerun the &quot;halt,up and provision&quot; commands,if you still face any issues,try destroying vagrant and create again via &quot;vagrant destroy &amp;&amp; vagrant up &amp;&amp; vagrant provision&quot;

**To setup the project inside your drupal vm:**

Add your new dvm&#39;s ssh key into Git Repo:

        ssh-keygen -t rsa -b 4096-C &quot;&lt;your\_email\_id&gt;&quot;

         eval&quot;$(ssh-agent -s)&quot;

           ssh-add ~/.ssh/id\_rsa

        cat &lt;~/.ssh/id\_rsa.pub

Copy the key and paste into your github account [https://github.com/settings/keys](https://github.com/settings/keys)

Initial Setup and Onboarding:

Follow the onboarding document in [http://blt.readthedocs.io/en/latest/readme/onboarding/](http://blt.readthedocs.io/en/latest/readme/onboarding/)

Below are the procedure for example by following the document.

 Fork the Project Repo git@github.com:acquia-pso/tateandlyle.git

git clone git@github.com:&lt;your\_username&gt;/tateandlyle.git
git remote add upstream git@github.com:acquia-pso/tateandlyle.git

git checkout master

Setup the Virtual Host:

Add below code in your/etc/apache2/sites-enabled/vhosts.conf

&lt;VirtualHost \*:80&gt;

  ServerNametal.local

  ServerAlias www.tal.local

  DocumentRoot/var/www/dvm/tateandlyle/docroot

  &lt;Directory&quot;/var/www/dvm/tateandlyle/docroot&quot;&gt;

    AllowOverrideAll

    Options-Indexes+FollowSymLinks

    Require all granted

  &lt;/Directory&gt;

  ProxyPassMatch^/(.\*\.php(/.\*)?)$ &quot;fcgi://127.0.0.1:9000/var/www/dvm/tateandlyle/docroot&quot;

&lt;/VirtualHost&gt;

Restart apache&quot;sudo /etc/init.d/apache2 restart&quot;



Create database

        echo &quot;Create database tateandlyle;&quot; | mysql -uroot -proot

Setup the Portal:

cd /var/www/dvm/tateandlyle

composer install -vvv —profile

composer blt-alias

        source /home/vagrant/.bashrc

        blt -l

blt setup:settings

- Add your DB credentials in
  - /var/www/dvm/tateandlyle/docroot/sites/default/settings/local.settings.php
- Check your drush URL aliases in
  - /var/www/dvm/tateandlyle/docroot/sites/default/local.drushrc.php

Setup Drush Alias:

Create and edit your local drush alias file. Copy drush/site-aliases/example.local.aliases.drushrc.php to drush/site-aliases/local.aliases.drushrc.php. Edit the new alias file with your local path.

Example:

$aliases[&#39;tal.local&#39;]= array(

 &#39;uri&#39;=&gt;&#39;tal.local&#39;,

 &#39;root&#39;=&gt;&#39;/var/www/dvm/tateandlyle/docroot&#39;,

 &#39;path-aliases&#39;=&gt; array(

   &#39;%dump-dir&#39;=&gt;&#39;/tmp&#39;,

 ),

);

Complete the setup:

blt local:setup

Add your project url in mac host file &#39;/etc/hosts&#39;

sudo vim /etc/hosts

        Add&quot;192.168.99.99   tal.local&quot;inend of the line.

Restart or reload vagrant by running

vagrant halt &amp;&amp; vagrant up or  vagrant reload

Now, access the project via &#39;http://tal.local&#39; in your browser.

- You should see &#39; **Welcome to Tate and Lyle**&#39;
- If you see default drupal instance similar to dvm.dev , then reload vagrant and try again.