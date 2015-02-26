$(document).ready(function() {
	$(function () {
    var pstyle = 'border: 1px solid #dfdfdf; padding: 5px;';
    var leftstyle = 'border: 1px solid #dfdfdf; padding: 5px; height: 400px';
    var mainstyle = 'border: 1px solid #dfdfdf; padding: 5px; height: 800px';
    $('#layout').w2layout({
        name: 'layout',
        padding: 2,
        panels: [
            { type: 'top', size: 75, resizable: false, style: pstyle, content: 'top' },
            { type: 'left', size: 250, resizable: false, style: leftstyle, content: 'left' },
            { type: 'main', size: 680, style: mainstyle, content: 'main' },
            //{ type: 'right', size: 200, resizable: false, style: pstyle, content: 'right' },
            //{ type: 'bottom', size: 40, resizable: true, style: pstyle, content: 'bottom'}
        ]
    });


   w2ui['layout'].load('top', 'top.html', function () {
    	console.log('content T loaded');
	});
   w2ui['layout'].load('left', 'left.html', function () {
    	console.log('content L loaded');
	});
   w2ui['layout'].load('main', 'main.php', function () {
    	console.log('content M loaded');
	});
   w2ui['layout'].load('right', 'right.html', function () {
    	console.log('content R loaded');
	});
   w2ui['layout'].load('bottom', 'bottom.html', function () {
   		console.log('content B loaded')
    });
});
});