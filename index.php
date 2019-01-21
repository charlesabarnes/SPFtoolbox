<html>
<head>
<title> SPFToolbox </title>
<meta name="description" content="SPFtoolbox is a Javascript and PHP app to look up DNS records such as SPF, MX, Whois, and more">
<meta property="og:description" content="SPFtoolbox is a Javascript and PHP app to look up DNS records such as SPF, MX, Whois, and more" />
<meta name="keywords" content="Github, Open Source, MXToolbox, DNS, Blacklist, MX, PHP">
<meta name="author" content="Charles Barnes">
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />

<meta name="msapplication-TileColor" content="#44c0f0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="SPFToolbox">
<meta name="theme-color" content="#44c0f0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<link href="styles/style.css" rel="stylesheet">

<script src ="javascript/main.js"></script>


</head>
<body>
    <a href="https://github.com/charlesabarnes/SPFtoolbox" class="github-corner" aria-label="View source on Github"><svg width="80" height="80" viewBox="0 0 250 250" style="fill:#44c0f0; color:#fff; position: absolute; top: 0; border: 0; right: 0;" aria-hidden="true"><path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"></path><path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2" fill="#fff" style="transform-origin: 130px 106px;" class="octo-arm"></path><path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z" fill="#fff" class="octo-body"></path></svg></a><style>.github-corner:hover .octo-arm{animation:octocat-wave 560ms ease-in-out}@keyframes octocat-wave{0%,100%{transform:rotate(0)}20%,60%{transform:rotate(-25deg)}40%,80%{transform:rotate(10deg)}}@media (max-width:500px){.github-corner:hover .octo-arm{animation:none}.github-corner .octo-arm{animation:octocat-wave 560ms ease-in-out}}</style>
    <div class="container">
        <div class="row" id="top-row">
            <div class="col-md-12">
                <H1 class="logo"><Span class = "logo-style1">SPF</Span>Toolbox</H1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                    <span class="form-label">Domain:&nbsp;</span><input type="text" name="domain" id="domain" class="form-control">
                    <select id="file" class="form-control">
                        <option value="all">Get All Simple DNS Records</option>
                        <option value="a">IP/Get A Record</option>
                        <option value="aaaa">IPV6/Get AAAA Record</option>
                        <option value="mx">Mx/Get MX Record</option>
                        <option value="txt">SPF/TXT</option>
                        <option value="blacklist">Blacklist Check</option>
                        <option value="whois">Whois</option>
                        <option value="port">Check Port</option>
                        <option value="hinfo">Hinfo/Get Hardware Information</option>
                        <option value="reverseLookup">Host By IP/Reverse Lookup</option>
                    </select>
                    <input type="button" id="submit" value="submit" class="form-control btn"/>
            </div>
            <div class="col-md-6"></div>
            <div>

                <div class="col-md-6"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <span id="txtHint" style="color: red;"></span>
                <span id="loading"></span>
            </div>
        </div>
        <div class="row">
                <div id="responseArea">
                    <div  class="responseTable">
                        
                    </div>
                </div>
        </div>        
    </div>
</body>
</html>
