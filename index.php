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

<title>SPFToolbox - DNS Lookup Tool</title>
<meta name="msapplication-TileColor" content="#3498db">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="SPFToolbox">
<meta name="theme-color" content="#3498db">

<link href="styles/style.css" rel="stylesheet">

</head>
<body>
    <a href="https://github.com/charlesabarnes/SPFtoolbox" class="github-corner" aria-label="View source on Github">
        <svg width="80" height="80" viewBox="0 0 250 250" aria-hidden="true">
            <path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"></path>
            <path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2" fill="currentColor" style="transform-origin: 130px 106px;" class="octo-arm"></path>
            <path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z" fill="currentColor" class="octo-body"></path>
        </svg>
    </a>

    <div class="theme-toggle">
        <span class="theme-toggle-label">Dark Mode</span>
        <label class="switch">
            <input type="checkbox" id="theme-toggle">
            <span class="slider">
                <span class="light-icon">☀️</span>
                <span class="dark-icon">🌙</span>
            </span>
        </label>
    </div>

    <header>
        <div class="container">
            <div class="row" id="top-row">
                <div class="col-md-12">
                    <h1 class="logo"><span class="logo-style1">SPF</span>Toolbox</h1>
                    <p class="subtitle">Analyze DNS records quickly and easily</p>
                </div>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div id="domain-container">
                        <span class="form-label">Domain:</span>
                        <input type="text" name="domain" id="domain" class="form-control" placeholder="example.com">
                        <select onchange="showAdditionalFields()" id="file" class="form-control">
                            <option value="a">IP/Get A Record</option>
                            <option value="aaaa">IPV6/Get AAAA Record</option>
                            <option value="mx">Mx/Get MX Record</option>
                            <option value="txt">SPF/TXT</option>
                            <option value="dmarc">DMARC</option>
                            <option value="blacklist">Blacklist Check</option>
                            <option value="whois">Whois</option>
                            <option value="port">Check If Port Open/Forwarded</option>
                            <option value="hinfo">Hinfo/Get Hardware Information</option>
                            <option value="all">Get All Simple DNS Records</option>
                            <option value="reverseLookup">Host By IP/Reverse Lookup</option>
                        </select>
                    </div>

                    <div id="port-container" style="visibility: hidden">
                        <span class="form-label">Port:</span>
                        <input type="text" name="port" id="port" class="form-control" placeholder="80">
                    </div>

                    <div id="submit-container">
                        <button type="button" id="submit" class="btn">Lookup</button>
                    </div>
                </div>

                <span id="txtHint" style="color: var(--danger-color);"></span>

                <div id="loading">
                    <div class="card info">
                        <h3>About SPF Toolbox</h3>
                        <span>SPF Toolbox was created to be an easy, free open source way for people to get information about their domain. Please click the link in the top right to let me know if you have any questions or suggestions for the app.</span>
                        
                        <table>
                            <thead>
                                <tr>
                                    <th>Query</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                    <td>MX stands for Mail Exchanger. This query is used to get the mail server used for accepting emails on the specified domain.</td>
                                </tr>
                                <tr>
                                    <td>SPF/TXT</td>
                                    <td>A SPF Record is used to indicate which email hosts is authorized to send mail on the specified domain's behalf. This query is used to get the authorized domains</td>
                                </tr>
                                <tr>
                                    <td>DMARC</td>
                                    <td>A DMARC Record is used to authenticate email From: addresses and defines policies on where to report both authorized and unauthorized mailflow</td>
                                </tr>
                                <tr>
                                    <td>Blacklist Check</td>
                                    <td>This query is used to check if the specified domain is on any of the most well known email blacklist sites. If a domain is on a blacklist the row will return a fail result.</td>
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
                                    <td>This query attemps to do a request for all of the available DNS information for the specified hostname. This is not always successfull as some providers block the request.</td>
                                </tr>
                                <tr>
                                    <td>Host By IP/Reverse Lookup</td>
                                    <td>The query attempts to find a hostname associated with an IP address</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div id="responseArea">
                    <div class="responseTable">
                        <!-- Results will be populated here -->
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>Created by <a href="https://charlesabarnes.com">Charles Barnes</a> | Contact: <a href="mailto:charles@charlesabarnes.com">charles@charlesabarnes.com</a></p>
                </div>
            </div>
        </div>
    </footer>

    <script src="javascript/main.js"></script>
</body>
</html>