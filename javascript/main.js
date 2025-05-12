document.addEventListener('DOMContentLoaded', function() {
    initTheme();

    // Add keyup event to trigger submit when Enter is pressed
    document.getElementById('domain').addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            document.getElementById('submit').click();
        }
    });

    // Add port input Enter key support
    document.getElementById('port').addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            document.getElementById('submit').click();
        }
    });

    // Handle form submission
    document.getElementById('submit').addEventListener('click', function() {
        const domain = document.getElementById('domain').value;
        const callType = document.getElementById('file').value;
        const port = document.getElementById('port').value;

        returnDnsDetails(domain, callType, port);
    });

    function initTheme() {
        const savedTheme = localStorage.getItem('spftoolbox-theme');
        const themeToggle = document.getElementById('theme-toggle');

        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
            themeToggle.checked = savedTheme === 'dark';
        } else {
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (prefersDark) {
                document.documentElement.setAttribute('data-theme', 'dark');
                themeToggle.checked = true;
            }

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                const newTheme = e.matches ? 'dark' : 'light';
                document.documentElement.setAttribute('data-theme', newTheme);
                themeToggle.checked = e.matches;
            });
        }

        themeToggle.addEventListener('change', function() {
            const newTheme = this.checked ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('spftoolbox-theme', newTheme);
        });
    }

    // Map call type to display title
    function requestTitle(callType) {
        const titles = {
            'txt': 'SPF/TXT Lookup',
            'mx': 'MX Lookup',
            'dmarc': 'DMARC',
            'a': 'IP Lookup',
            'all': 'All available DNS records',
            'aaaa': 'IPV6 Lookup',
            'whois': 'Who Is Lookup',
            'hinfo': 'H Info Lookup',
            'blacklist': 'Blacklist Lookup',
            'port': 'Ports Lookup',
            'reverseLookup': 'Host Lookup'
        };
        
        return titles[callType] || 'DNS Lookup';
    }

    // Get DNS details using Fetch API
    function returnDnsDetails(domain, callType, port) {
        // Validate input
        if (!domain || domain.trim() === '') {
            document.getElementById('txtHint').innerHTML = "Please enter a valid domain";
            return;
        }
        
        // Clear previous error message
        document.getElementById('txtHint').innerHTML = "";
        
        // Show loading spinner
        document.getElementById('loading').innerHTML = 
            createLoadingTemplate();
        
        // Prepare URL
        const url = `operations/?domain=${encodeURIComponent(domain)}&request=${callType}&port=${port}`;
        
        // Fetch data
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Clear loading indicator
                document.getElementById('loading').innerHTML = '';
                
                // Build table with data
                buildTable(data, callType);
            })
            .catch(error => {
                // Handle error
                document.getElementById('loading').innerHTML = '';
                document.getElementById('txtHint').innerHTML = `Error: ${error.message}. Please try again.`;
            });
    }

    // Create loading spinner template
    function createLoadingTemplate() {
        return `
            <div class="sk-three-bounce">
                <div class="sk-child sk-bounce1"></div>
                <div class="sk-child sk-bounce2"></div>
                <div class="sk-child sk-bounce3"></div>
            </div>
        `;
    }

    // Create table header template
    function createTableHeaderTemplate(title) {
        return `
            <tr>
                <td class="thead" colspan="2">${title}</td>
            </tr>
        `;
    }

    // Create no data template
    function createNoDataTemplate() {
        return `
            <tr>
                <td colspan="2" style="text-align: center;">NO DATA FOUND</td>
            </tr>
        `;
    }

    // Create data row template
    function createDataRowTemplate(key, value, isBlacklist) {
        const displayValue = isBlacklist ? value : cleanString(String(value));
        return `
            <tr class="twoCol">
                <td class="left-row">${key}:</td>
                <td>${displayValue}</td>
            </tr>
        `;
    }

    // Build results table with templating
    function buildTable(jsonResp, callType) {
        // Generate unique ID for this result set
        const resultId = Date.now();
        const responseTable = document.querySelector('.responseTable');
        
        // Create result row container
        const resultRow = document.createElement('div');
        resultRow.className = 'responseRow' + resultId;
        
        // Check if results exist
        if (!jsonResp || jsonResp.length === 0) {
            resultRow.innerHTML = `
                <table>
                    ${createTableHeaderTemplate(requestTitle(callType))}
                    ${createNoDataTemplate()}
                </table>
            `;
        } else {
            // Process results with templating
            let tableHtml = '';
            
            jsonResp.forEach((jsonData, index) => {
                // Create HTML for each result object
                if (index === 0) {
                    // First result goes in the main table
                    tableHtml = `<table>${createTableHeaderTemplate(requestTitle(callType))}`;
                    
                    // Add data rows
                    Object.entries(jsonData).forEach(([key, value]) => {
                        tableHtml += createDataRowTemplate(key, value, callType === 'blacklist.php');
                    });
                    
                    tableHtml += '</table>';
                } else {
                    // Additional results get their own tables
                    tableHtml += `
                        <div class="responseRow${resultId + index}">
                            <table>
                                ${createTableHeaderTemplate(requestTitle(callType) + ' (continued)')}
                    `;
                    
                    // Add data rows
                    Object.entries(jsonData).forEach(([key, value]) => {
                        tableHtml += createDataRowTemplate(key, value, callType === 'blacklist.php');
                    });
                    
                    tableHtml += '</table></div>';
                }
            });
            
            resultRow.innerHTML = tableHtml;
        }
        
        // Add the new result to the top of the results area
        responseTable.insertBefore(resultRow, responseTable.firstChild);
        
        // Scroll to the results
        resultRow.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Sanitize strings to prevent XSS
    function cleanString(data) {
        return data
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
});

// Show/hide port input field based on selection
function showAdditionalFields() {
    const fileSelect = document.getElementById('file');
    const portContainer = document.getElementById('port-container');
    
    if (fileSelect.value === 'port') {
        portContainer.style.visibility = 'visible';
        document.getElementById('port').focus();
    } else {
        portContainer.style.visibility = 'hidden';
    }
}