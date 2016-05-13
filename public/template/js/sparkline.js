$(function () {
   
    $("#sparkline1").sparkline([5, 6, 7, 2, 0, 4,8, 2, 13, 5, 7, 2, 4, 12, 4, 2, 4, 5, 7, 2, 4, 12, 14, 4, 2, 14, 12, 7], {
        type: 'bar',
        barWidth: 4,
        height: '50px',
        barColor: '#757092',
        negBarColor: '#c6c6c6'
    });
    $("#sparkline2").sparkline([5, 6, 7, 2, 0, 4, 2, 4, 5, 7, 2, 4, 6, 14, 3, 2, 9, 12,8, 2, 13, 5, 7, 2, 4, 12, 4, 9], {
        type: 'bar',
        barWidth: 4,
        height: '50px',
        barColor: '#757092',
        negBarColor: '#c6c6c6'
    });
    $("#sparkline3").sparkline([5, 6, 7,8, 2, 13, 5, 7, 2, 4, 12, 4, 2, 0, 4, 13, 10, 5, 8, 9, 4, 12, 14, 4, 2, 14, 12, 2], {
        type: 'bar',
        barWidth: 4,
        height: '50px',
        barColor: '#757092',
        negBarColor: '#c6c6c6'
    });
    $("#sparkline4").sparkline([10, 9, 11, 6, 5, 8, 2, 13, 5, 7, 2, 4, 12, 4,8, 2, 13, 5, 7, 2, 4, 12, 4, 3, 2, 0, 0, 4], {
        type: 'bar',
        barWidth: 4,
        height: '50px',
        barColor: '#757092',
        negBarColor: '#c6c6c6'
    });

    
});
