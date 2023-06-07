/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const EditBlock = ( props ) => {
	const { className } = props;
	return (
		<div class={ className }>
			<p>
				<strong>{ __('This is a block for testing the schema', 'gato-graphql-testing-schema') }</strong>
			</p>
			<p>
			{ __('In particular, to test field `CustomPost.blocks`, to see that blocks not registered on the server-side cannot be parsed.', 'gato-graphql-testing-schema') }
			</p>
		</div>
	)
}

export default EditBlock;
