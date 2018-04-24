var data = JSON.parse(php_vars);

var width = 600;
height = d3.max(data, function(d){ return d.posts *100});
barWidth = 20;

var yScale = d3.scaleLinear()
    .domain([0, height])
    .range([height, 0]);

d3.select("svg")
    .attr("width", width)
    .attr("height", height)
    .selectAll("rect")
    .data(data)
    .enter()
    .append("rect")
    .attr("width", barWidth )
    .attr("height", function(d) {
        return d.posts *100 ;
    })
    .attr("y", function (d) {
        return yScale(d);
    })
    .attr("x", function (d, i) {
        return ( barWidth + 10) *i;
    })
    .attr("fill", "black");