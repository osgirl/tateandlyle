<?php
/**
 * SAML 2.0 remote IdP metadata for simpleSAMLphp.
 *
 * Remember to remove the IdPs you don't use from this file.
 *
 * See: https://rnd.feide.no/content/idp-remote-metadata-reference
 */

$metadata['saml20:test:tateandlyle.com'] = array (
	'name' => array(
		'en' => 'Tate & Lyle PingFederation',
	),
	'entityid' => 'saml20:test:tateandlyle.com',
	'contacts' =>
		array (
			0 =>
				array (
					'contactType' => 'administrative',
					'company' => 'Tate & Lyle',
				),
		),
	'metadata-set' => 'saml20-idp-remote',
	'SingleSignOnService' =>
		array (
			0 =>
				array (
					'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
					'Location' => 'https://pingssotest.tlww.net/idp/SSO.saml2',
				),
			1 =>
				array (
					'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
					'Location' => 'https://pingssotest.tlww.net/idp/SSO.saml2',
				),
			2 =>
				array (
					'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Artifact',
					'Location' => 'https://pingssotest.tlww.net/idp/SSO.saml2',
				),
			3 =>
				array (
					'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
					'Location' => 'https://pingssotest.tlww.net/idp/SSO.saml2',
				),
		),
	'SingleLogoutService' =>
		array (
			0 =>
				array (
					'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
					'Location' => 'https://pingssotest.tlww.net/idp/SLO.saml2',
				),
			1 =>
				array (
					'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
					'Location' => 'https://pingssotest.tlww.net/idp/SLO.saml2',
				),
			2 =>
				array (
					'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Artifact',
					'Location' => 'https://pingssotest.tlww.net/idp/SLO.saml2',
				),
			3 =>
				array (
					'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
					'Location' => 'https://pingssotest.tlww.net/idp/SLO.ssaml2',
				),
		),
	'ArtifactResolutionService' =>
		array (
			0 =>
				array (
					'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
					'Location' => 'https://pingssotest.tlww.net/idp/ARS.ssaml2',
					'index' => 0,
					'isDefault' => true,
				),
		),
	'keys' =>
		array (
			0 =>
				array (
					'encryption' => false,
					'signing' => true,
					'type' => 'X509Certificate',
					'X509Certificate' => 'MIIB0TCCATqgAwIBAgIGAVKhnuRkMA0GCSqGSIb3DQEBBQUAMCwxCzAJBgNVBAYTAlVLMQ8wDQYDVQQKEwZBY3F1aWExDDAKBgNVBAMTA0NNUzAeFw0xNjAyMDIxMDU0NTBaFw0xNzAyMDExMDU0NTBaMCwxCzAJBgNVBAYTAlVLMQ8wDQYDVQQKEwZBY3F1aWExDDAKBgNVBAMTA0NNUzCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAuCR9M3jAJ/9QXO852eE8seoyZPYFWW7xkjxjlJyoWydSyhIVze60XfHCy4T84mx/ySVPvzd0r2q1775hW5g/JdIhxnouLL/eM7Z9Xr5bmOCm+fhZzmUc4tFe8U56zw7BEWfDLlm2G8xUZmZtzxau3R6MlE51ArhyV1TZXxbEYucCAwEAATANBgkqhkiG9w0BAQUFAAOBgQCCYwvo8fkqHDAek8+Nyf7KZnUng9KOR1zkjj1tuNUkdbVR5KR2IzqSpg35rqlFkY2TsFBjhzXknyf5BuR5XcjcXn4GFNFxNNGTNQjMqKKRoY0LNBIuHGUwbpPLOiCgpcgxJBjP+SMuBXk1CETlAhWiH5XDi2x4FIY9/Zhkj/f8oQ==',
				),
		),
);