var tywChart = jQuery( document ).ready( function() {

	var data = JSON.parse( tyw_month_chart_data );

	var margin = { top: 30, right: 30, bottom: 40, left: 50 };
	width = 600 - margin.left - margin.right;
	height = 300 - margin.bottom - margin.top;
	barWidth = width / data.length;
	padding = 2;
	tickPadding = 10;

	var MaxPosts, colorScale, yScale, monthChartSvg, monthChartBar,
		yAxis, xScale, xAxis, currentTime, year;

	MaxPosts = d3.max( data, function(d) {
		return d.posts;
	} );

	colorScale = d3.scaleLinear()
		.domain( [0, MaxPosts] )
		.range( ['gray', 'green'] );

	yScale = d3.scaleLinear()
		.domain( [0, MaxPosts] )
		.range( [height, 0] );

	monthChartSvg = d3.select( '#tyw_month_chart' )
		.attr( 'width', width + margin.right + margin.left )
		.attr( 'height', height + margin.bottom + margin.top )
		.append( 'g' )
		.attr( 'transform', 'translate('+ margin.left + ', ' + margin.top + ')' );


	monthChartBar = monthChartSvg.selectAll( 'g' )
		.data( data )
		.enter()
		.append( 'rect' )
		.attr( 'height', function(d) {
			return height - yScale( d.posts );
		} )
		.attr( 'width', barWidth - padding )
		.attr( 'x', function(d, i) {
			return i * barWidth;
		} )
		.attr( 'y', function(d) {
			return yScale(d.posts);
		} )
		.attr( 'fill', function(d) {
			return colorScale( d.posts);
		} );

	yAxis = d3.axisLeft( yScale);

	d3.select( '#tyw_month_chart' )
		.append( 'g' )
		.attr( 'transform', 'translate('+ margin.left + ',' + margin.top + ')' )
		.call( yAxis );


	currentTime = new Date();
	year = currentTime.getFullYear();

	xScale = d3.scaleTime()
		.domain( [new Date( year, 0, 1 ), new Date( year, 11, 31 )] )
		.range( [0, width] );

	xAxis = d3.axisBottom( xScale)
		.tickFormat( d3.timeFormat( '%b' ) )
		.tickPadding( [tickPadding] );

	d3.select( '#tyw_month_chart' )
		.append( 'g' )
		.attr( 'class', 'x axis' )
		.attr( 'transform', 'translate(' + margin.left +',' + (height + margin.top +')' ) )
		.call( xAxis )
		.selectAll( '.tick text' )
		.style( 'text-anchor', 'start' )
		.attr( 'x', 12 )
		.attr( 'y', 6 );

});
