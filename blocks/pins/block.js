const { registerBlockType } = wp.blocks;
const el = wp.element.createElement;
const Fragment = wp.element.Fragment;
const InspectorControls = wp.editor.InspectorControls;
const TimePicker = wp.components.TimePicker;


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
						}
					}
    			)
    		)
    	),
    	el(
    		'p',
    		{ style: blockStyle },
    		'Showing pins from between ' + props.attributes.startDate + ' and ' + props.attributes.endDate
    		)
    	];
    },
    save: function( props ) {
    	return el(
    		'p',
    		{ style: blockStyle },
    		'Showing (front) pins from between ' + props.attributes.startDate + ' and ' + props.attributes.endDate);
    }
} );
