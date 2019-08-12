const { registerBlockType } = wp.blocks;
const el = wp.element.createElement;
const Fragment = wp.element.Fragment;
const InspectorControls = wp.editor.InspectorControls;
const {
	BaseControl,
	TimePicker,
	PanelBody,
	PanelRow
} = wp.components;

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
					{
						href: (item.meta ? item.meta.url : ''),
						dangerouslySetInnerHTML: {
							__html: item.title.rendered
						} },
					null,
					),
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
	props.setAttributes({ pinJson: apiJson });
}


const blockStyle = {
	// No custom styles
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
				InspectorControls,
				null,
				el(
					PanelBody,
					{ title: 'Date range' },
					el (
						PanelRow,
						null,
						el (
							BaseControl,
							{
								id: 'start-date',
								label: 'Start Date',
								help: 'When do you want your list of pins to start?'
							},
							el (
								TimePicker,
								{
									currentTime: startDate,
									onChange: function (timestamp) {
										props.setAttributes({ startDate: timestamp });
										fetchPins(props.attributes.startDate, props.attributes.endDate, props);
									}
								}
							)
						)
					),
					el (
						PanelRow,
						null,
						el (
							BaseControl,
							{
								id: 'end-date',
								label: 'End Date',
								help: 'When do you want your list of pins to end?'

							},
							el(
								TimePicker,
								{
									currentTime: endDate,
									onChange: function (timestamp) {
										props.setAttributes({ endDate: timestamp });
										fetchPins(props.attributes.startDate, props.attributes.endDate, props);
									}
								}
							)
						)
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
