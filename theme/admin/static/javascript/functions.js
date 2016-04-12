function noop(){}

function sortObject(objs, prop){
    var sortableObject = [];
    
    for(var k in objs)
        sortableObject.push([objs[k],k,objs[k][prop]]);
    
    sortableObject.sort(function(a,b){ return (prop ? (b[2]-a[2]) : (b[0]-a[0])); });
    
    var newObject = {};
    for(var i=0; i<sortableObject.length; i++)
        newObject[sortableObject[i][1]] = sortableObject[i][0];
    return newObject;
}