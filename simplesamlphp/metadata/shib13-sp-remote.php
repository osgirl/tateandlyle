<?php
/**
 * Created by PhpStorm.
 * User: jayakrishnan
 * Date: 1/17/17
 * Time: 9:01 PM
 */

$metadata['http://tatelylecomdev.prod.acquia-sites.com/simplesaml/module.php/saml/sp/metadata.php/tatelyle-test-sp'] = array (
  'entityid' => 'http://tatelylecomdev.prod.acquia-sites.com/simplesaml/module.php/saml/sp/metadata.php/tatelyle-test-sp',
  'contacts' =>
    array (
      0 =>
        array (
          'contactType' => 'technical',
          'givenName' => 'Jayakrishnan',
          'surName' => 'Jayabal',
          'emailAddress' =>
            array (
              0 => 'jayakrishnan.jayabal@acquia.com',
            ),
        ),
    ),
  'metadata-set' => 'shib13-sp-remote',
  'AssertionConsumerService' =>
    array (
      0 =>
        array (
          'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
          'Location' => 'http://tatelylecomdev.prod.acquia-sites.com/simplesaml/module.php/saml/sp/saml2-acs.php/tatelyle-test-sp',
          'index' => 0,
        ),
      1 =>
        array (
          'Binding' => 'urn:oasis:names:tc:SAML:1.0:profiles:browser-post',
          'Location' => 'http://tatelylecomdev.prod.acquia-sites.com/simplesaml/module.php/saml/sp/saml1-acs.php/tatelyle-test-sp',
          'index' => 1,
        ),
      2 =>
        array (
          'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Artifact',
          'Location' => 'http://tatelylecomdev.prod.acquia-sites.com/simplesaml/module.php/saml/sp/saml2-acs.php/tatelyle-test-sp',
          'index' => 2,
        ),
      3 =>
        array (
          'Binding' => 'urn:oasis:names:tc:SAML:1.0:profiles:artifact-01',
          'Location' => 'http://tatelylecomdev.prod.acquia-sites.com/simplesaml/module.php/saml/sp/saml1-acs.php/tatelyle-test-sp/artifact',
          'index' => 3,
        ),
    ),
);