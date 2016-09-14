---
layout: post
title: Generator Model
category: Generator
---

<form id="form">
    <input type="text" id="form-table" placeholder="Table name" autofocus="autofocus" pattern="^[a-z]([\w\-]+)$">
    <input type="text" id="form-database" placeholder="Database name" pattern="^[a-z]([\w\-]+)$">
    <button>Generate</button> <a id="btn-download">Download</a>
</form>

<div>&#160;</div>

<pre id="result"></pre>

<script>
var form = document.querySelector('form');
var btnDownload = document.querySelector('#btn-download');
btnDownload.style.display = 'none';
form.addEventListener('submit', function(e){
    var tableName = document.querySelector('#form-table').value;
    var modelName = ( tableName[0].toUpperCase() + tableName.slice(1).toLowerCase() ).replace(/[^a-zA-Z0-9]/g, '') + '_model';
    var dbName    = document.querySelector('#form-database').value;
    
    btnDownload.style.display = 'inline';
    btnDownload.setAttribute('download', modelName + '.php');
    
    var script = [
            '&lt;?php',
            '',
            'if(!defined(\'BASEPATH\'))',
            '   die;',
            '',
            '/**',
            ' * The model of table `' + tableName + '`',
            ' */',
            'class ' + modelName + ' extends MY_Model',
            '{',
            '    /**',
            '     * Table name',
            '     * @var string',
            '     */',
            '    public $table = \'' + tableName + '\';',
            ''
        ];
    
    if(dbName){
        script = script.concat([
            '    /**',
            '     * Database name',
            '     * @var string',
            '     */',
            '    public $dbname = \'' + dbName + '\';',
            ''
        ]);
    }
    
    script = script.concat([
            '    /**',
            '     * Constructor',
            '     */',
            '    function __construct(){',
            '        $this->load->database();',
            '        parent::__construct();',
            '    }',
            '}'
    ]);
    
    script = script.join('\n');
    
    document.querySelector('#result').innerHTML = script;
    
    btnDownload.setAttribute('href', 'data:text/plain,'+encodeURIComponent(script.replace('&lt;', '<')));
    e.preventDefault();
});
</script>