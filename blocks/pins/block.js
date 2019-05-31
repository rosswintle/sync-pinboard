const { registerBlockType } = wp.blocks;
const el = wp.element.createElement;
const Fragment = wp.element.Fragment;
const InspectorControls = wp.editor.InspectorControls;
const TimePicker = wp.components.TimePicker;

function createSyncPinboardList(props) {
	const pins = props.attributes.pinJson;
	const listItems = [];

	pins.forEach( function(item, index) {
		listItems.push(
			el(
				'li',
				null,
				el(
					'a',
					{ href: (item.meta ? item.meta.url : '') },
					null,
					item.title.rendered),
				el(
					'span',
					null,
					' - '),
				el(
					'span',
					null,
					item.content_raw)
				));
	});

	const list = el(
		'ul',
		null,
		...listItems);

	return list;
}

async function fetchPins (startDate, endDate, props) {
	// TODO: localise this
	let response = await fetch(`/wp-json/wp/v2/pinboard-bookmark/?after=${startDate}&before=${endDate}&per_page=100`);
	let apiJson = await response.json();
	console.log(apiJson);
	props.setAttributes({ pinJson: apiJson });
}


const blockStyle = {
    backgroundColor: '#900',
    color: '#fff',
    padding: '20px',
};

registerBlockType( 'sync-pinboard/pins', {
    title: 'Pins',
    icon: 'post-status',
    category: 'common',
    attributes: {
		startDate: {
    		type: 'string',
    		default: moment().format('YYYY-MM-DDTHH:mm:ss')
    	},
    	endDate: {
    		type: 'string',
    		default: moment().format('YYYY-MM-DDTHH:mm:ss')
    	},
    	pinJson: {
    		type: 'array',
    		default: [],
    	}
    },
    edit: function( props ) {
    	let startDate = props.attributes.startDate;
    	let endDate = props.attributes.endDate;

    	return [
    	el(
    		Fragment,
    		null,
    		el(
    			InspectorControls,
    			null,
    			el(
    				TimePicker,
    				{
    					label: 'Start date/time',
    					currentTime: startDate,
    					onChange: function (timestamp) {
    						props.setAttributes({ startDate: timestamp });
    						fetchPins(props.attributes.startDate, props.attributes.endDate, props);
    					}
    				}
    				),
    			el(
    				TimePicker,
    				{
    					label: 'End date/time',
    					currentTime: endDate,
    					onChange: function (timestamp) {
    						props.setAttributes({ endDate: timestamp });
    						fetchPins(props.attributes.startDate, props.attributes.endDate, props);
    					}
    				}
    				)
    			)
    		),
    	createSyncPinboardList(props)
    	];
    },
    save: function( props ) {
    	const list = createSyncPinboardList(props);
    	return el(
    		'div',
    		{ style: blockStyle },
	    	list
	    );
    },
} );
