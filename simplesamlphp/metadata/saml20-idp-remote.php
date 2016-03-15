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
		'en' => 'Tate & Lyle PingFederation Test',
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

$metadata['saml20:tateandlyle.com'] = array (
	'name' => array(
		'en' => 'Tate & Lyle PingFederation Production',
	),
	'entityid' => 'saml20:tateandlyle.com',
	'contacts' =>
		array (
			0 =>
				array (
					'contactType' => 'administrative',
					'company' => 'Tate & Lyle',
					'givenName' => 'Jameson',
					'surName' => 'Wills',
					'emailAddress' =>
						array (
							0 => 'jameson.wills@tateandlyle.com',
						),
				),
		),
	'metadata-set' => 'saml20-idp-remote',
	'SingleSignOnService' =>
		array (
			0 =>
				array (
					'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
					'Location' => 'https://pingsso.tlww.net/idp/SSO.saml2',
				),
		),
	'SingleLogoutService' =>
		array (
		),
	'ArtifactResolutionService' =>
		array (
		),
	'keys' =>
		array (
			0 =>
				array (
					'encryption' => false,
					'signing' => true,
					'type' => 'X509Certificate',
					'X509Certificate' => 'MIIB3TCCAUagAwIBAgIGAVN2hKUjMA0GCSqGSIb3DQEBBQUAMDIxCzAJBgNVBAYTAlVLMQ8wDQYDVQQKEwZBY3F1aWExEjAQBgNVBAMTCURydXBhbENNUzAeFw0xNjAzMTQxOTA1MTdaFw0xNzAzMTQxOTA1MTdaMDIxCzAJBgNVBAYTAlVLMQ8wDQYDVQQKEwZBY3F1aWExEjAQBgNVBAMTCURydXBhbENNUzCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAnZcoNe1b83YY2fq71XC1/m8BpsekhH1uyexGeAgGunNq5mtjb6vHxlVLS+LLaLS7hjDOLCcj5H8yFs2HmE5coNavofomljzXHI77SbUc/Nj70E8DEfanNtPyi5zdZ6JXR2evRJ1i63tJOaVvGqRbAwvTwd8BIU2KE+5QkCAI6bECAwEAATANBgkqhkiG9w0BAQUFAAOBgQBMAQr6dqcmGS1ACnzvrSCYyedfTEhK7tYGM6Rlp/JPKR2C2/J2LrXkc2ZEEpGBSvWqakzC8/J7e/GviwpNqoRFKa8g8XKAdDKKoFeGxCg3dHWIpTkb2NYDv+nPXTqxOf+cxGItMMrAG67kHFK063qNdF45vgWQ2SNQc7fMq7lFJg==',
				),
		),
);