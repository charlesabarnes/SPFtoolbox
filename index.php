<?php

header("Cache-control: no-cache, max-age=0");
header("Expires: 0");
header("Expires: Tue, 01 Jan 1980 1:00:00 GMT");
header("Pragma: no-cache");

?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="SPFtoolbox is a Javascript and PHP app to look up DNS records such as SPF, MX, Whois, and more">
<meta property="og:description" content="SPFtoolbox is a Javascript and PHP app to look up DNS records such as SPF, MX, Whois, and more" >
<meta name="keywords" content="Github, Open Source, MXToolbox, DNS, Blacklist, MX, PHP">
<meta name="author" content="Charles Barnes">

<title> SPFToolbox </title>
<meta name="msapplication-TileColor" content="#44c0f0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="SPFToolbox">
<meta name="theme-color" content="#44c0f0">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="styles/style.css" rel="stylesheet">

</head>
<body>
    <a href="https://github.com/charlesabarnes/SPFtoolbox" class="github-corner" aria-label="View source on Github"><svg width="80" height="80" viewBox="0 0 250 250" style="fill:#44c0f0; color:#fff; position: absolute; top: 0; border: 0; right: 0;" aria-hidden="true"><path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"></path><path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2" fill="#fff" style="transform-origin: 130px 106px;" class="octo-arm"></path><path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z" fill="#fff" class="octo-body"></path></svg></a>
    <div class="container">
        <div class="row" id="top-row">
            <div class="col-md-12">
                <H1 class="logo"><Span class = "logo-style1">SPF</Span>Toolbox</H1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                    <div id="domain-container">
                        <span class="form-label">Domain:&nbsp;</span>
                        <input type="text" name="domain" id="domain" class="form-control">
                        <select onchange="showAdditionalFields()" id="file" class="form-control">
                            <option value="a">IP/Get A Record</option>
                            <option value="aaaa">IPV6/Get AAAA Record</option>
                            <option value="mx">Mx/Get MX Record</option>
                            <option value="txt">SPF/TXT</option>
                            <option value="blacklist">Blacklist Check</option>
                            <option value="whois">Whois</option>
                            <option value="port">Check If Port Open/Forwarded</option>
                            <option value="hinfo">Hinfo/Get Hardware Information</option>
                            <option value="all">Get All Simple DNS Records</option>
                            <option value="reverseLookup">Host By IP/Reverse Lookup</option>
                        </select>
                    </div>
                    <div style="visibility: hidden" id="port-container">
                        <span class="form-label">Port:&nbsp;</span><input type="text" name="port" id="port" class="form-control">
                    </div>
                    <div id="submit-container">
                        <input type="button" id="submit" value="submit" class="form-control btn"/>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <span id="txtHint" style="color: red;"></span>
                <div id="loading">
                <div class="info">
                <h3>About SPF Toolbox</h3>
                <span>SPF Toolbox was created to be an easy, free open source way for people to get information about their domain. Please click the link in the top right to let me know if you have any questions or suggestions for the app.</span>
                <br/>
                <br/>
                <br/>
                    <table>
                        <tr>
                            <th>Query</th>
                            <th>Description</th>
                        </tr>
                        <tr>
                            <td>IP/Get A Record</td>
                            <td>An A Record is used to associate a domain name with an IP(v4) address. This query checks for the A records set on the domain</td>
                        </tr>
                        <tr>
                            <td>IPV6/Get AAAA Record</td>
                            <td>An AAAA Record is used to associate a domain name with an IP(v6) address. This query checks for the AAAA records set on the domain</td>
                        </tr>
                        <tr>
                            <td>Mx/Get MX Record</td>
                            <td>MX stands for Mail Exchanger.  This query is used to get the mail server used for accepting emails on the specified domain.</td>
                        </tr>
                        <tr>
                            <td>SPF/TXT</td>
                            <td>A SPF Record is used to indicate which email hosts is authorized to send mail on the specified domain's behalf.  This query is used to get the authorized domains</td>
                        </tr>
                        <tr>
                            <td>Blacklist Check</td>
                            <td>This query is used to check if the specified domain is on any of the most well known email blacklist sites.  If a domain is on a blacklist the row will return a fail result.</td>
                        </tr>
                        <tr>
                            <td>Whois</td>
                            <td>This information gets whois information to see who possibly owns the domain.</td>
                        </tr>
                        <tr>
                            <td>Check If Port Open/Forwarded</td>
                            <td>You are able to Check if a specified port on a domain or IP address is open for use such as hosting</td>
                        </tr>
                        <tr>
                            <td>Hinfo/Get Hardware Information</td>
                            <td>If available, this query gets the hardware information of the server for the specified hostname</td>
                        </tr>
                        <tr>
                            <td>Get All Simple DNS Records</td>
                            <td>This query attemps to do a request for all of the available DNS information for the specified hostname.  This is not always successfull as some providers block the request.</td>
                        </tr>
                        <tr>
                            <td>Host By IP/Reverse Lookup</td>
                            <td>The query attempts to find a hostname associated with an IP address</td>
                        </tr>
                    </table>
                </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div id="responseArea" class="col-md-12">
                    <div  class="responseTable">
                            
                    </div>
                </div>
                <footer>
                    <div class="row text-center">
                        <div class="col-md-12">
                            <p>Created by <a href="https://charlesabarnes.com">Charles Barnes</a> | Contact: <a href="mailto:charles@charlesabarnes.com">charles@charlesabarnes.com</a></p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>        
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src ="javascript/main.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-88348393-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-88348393-1');
    </script>
</body>
</html>
