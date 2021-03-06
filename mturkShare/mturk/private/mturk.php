<?php

// Define constants 
$AWS_ACCESS_KEY_ID = "AKIAIKVVQBGBY5F7TUXA";
$AWS_SECRET_ACCESS_KEY = "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";
$SERVICE_NAME = "AWSMechanicalTurkRequester"; 
$SERVICE_VERSION = "2008-08-02"; 

if($endpoint == 'production') {
	$endpointURL = 'https://mechanicalturk.amazonaws.com';
} else {
	$endpointURL = 'https://mechanicalturk.sandbox.amazonaws.com'; // default to sandbox
}
$SERVICE_ENDPOINT = $endpointURL;


// Define authentication routines 
function generate_timestamp($time) { 
  return gmdate("Y-m-d\TH:i:s\\Z", $time); 
} 

function hmac_sha1($key, $s) { 
  return pack("H*", sha1((str_pad($key, 64, chr(0x00)) ^ (str_repeat(chr(0x5c), 64))) . 
						 pack("H*", sha1((str_pad($key, 64, chr(0x00)) ^ (str_repeat(chr(0x36), 64))) . $s)))); 
} 

function generate_signature($service, $operation, $timestamp, $secret_access_key) { 
  $string_to_encode = $service . $operation . $timestamp; 
  $hmac = hmac_sha1($secret_access_key, $string_to_encode); 
  $signature = base64_encode($hmac); 
  return $signature; 
} 

// Check for and print results and errors 
function print_errors($error_nodes) { 
  print "There was an error processing your request:\n"; 
  foreach ($error_nodes as $error) { 
	print "  Error code:    " . $error->Code . "\n"; 
	print "  Error message: " . $error->Message . "\n"; 
  } 
} 

function constructQuestion($url, $frame_height) { 
     $question1 = '<ExternalQuestion xmlns="http://mechanicalturk.amazonaws.com/AWSMechanicalTurkDataSchemas/2006-07-14/ExternalQuestion.xsd">'; 
     $question1 .= '<ExternalURL>'.$url.'</ExternalURL>'; 
     $question1 .= '<FrameHeight>'.$frame_height.'</FrameHeight>'; 
     $question1 .= '</ExternalQuestion>'; 

     return $question1; 
   } 