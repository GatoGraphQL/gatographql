/**
 * WordPress dependencies
 */
import { useSelect } from '@wordpress/data';
import { safeDecodeURIComponent } from '@wordpress/url';
import { __ } from '@wordpress/i18n';
import { ExternalLink } from '@wordpress/components';
import { store as editorStore } from '@wordpress/editor';

/**
 * Internal dependencies
 */
import './style.scss';

export default function CustomEndpointProperties() {
	const {
		postSlug,
		postLink,
		permalinkPrefix,
		permalinkSuffix,
		isCustomEndpointEnabled,
		isGraphiQLClientEnabled,
		isVoyagerClientEnabled,
	} = useSelect( ( select ) => {
		const post = select( editorStore ).getCurrentPost();
		const permalinkParts = select( editorStore ).getPermalinkParts();
		const blocks = select( editorStore ).getBlocks();
		const customEndpointOptionsBlock = blocks.filter(
			block => block.name === 'graphql-api/custom-endpoint-options'
		).shift();
		const graphiQLClientBlock = blocks.filter(
			block => block.name === 'graphql-api/endpoint-graphiql'
		).shift();
		const voyagerClientBlock = blocks.filter(
			block => block.name === 'graphql-api/endpoint-voyager'
		).shift();

		return {
			postSlug: safeDecodeURIComponent(
				select( editorStore ).getEditedPostSlug()
			),
			postLink: post.link,
			permalinkPrefix: permalinkParts?.prefix,
			permalinkSuffix: permalinkParts?.suffix,
			isCustomEndpointEnabled: customEndpointOptionsBlock.attributes.isEnabled,
			isGraphiQLClientEnabled: graphiQLClientBlock.attributes.isEnabled,
			isVoyagerClientEnabled: voyagerClientBlock.attributes.isEnabled,
		};
	}, [] );

	return (
		<>
			{ isCustomEndpointEnabled && (
				<>
					<div className="editor-post-url">
						<h3 className="editor-post-url__link-label">
							🟢 { __( 'Custom Endpoint URL' ) }
						</h3>
						<p>
							<ExternalLink
								className="editor-post-url__link"
								href={ postLink }
								target="_blank"
							>
								<>
									<span className="editor-post-url__link-prefix">
										{ permalinkPrefix }
									</span>
									<span className="editor-post-url__link-slug">
										{ postSlug }
									</span>
									<span className="editor-post-url__link-suffix">
										{ permalinkSuffix }
									</span>
								</>
							</ExternalLink>
						</p>
					</div>
					<hr/>
				</>
			) }
			<div className="editor-post-url">
				<h3 className="editor-post-url__link-label">
					🔵 { __( 'Endpoint Source' ) }
				</h3>
				<p>
					<ExternalLink
						className="editor-post-url__link"
						href={ postLink + '?view=source' }
						target="_blank"
					>
						<>
							<span className="editor-post-url__link-prefix">
								{ permalinkPrefix }
							</span>
							<span className="editor-post-url__link-slug">
								{ postSlug }
							</span>
							<span className="editor-post-url__link-suffix">
								{ permalinkSuffix }
							</span>
							<span className="editor-endoint-custom-post-url__link-view">
								{ '?view=' }
							</span>
							<span className="editor-endoint-custom-post-url__link-view-item">
								{ 'source' }
							</span>
						</>
					</ExternalLink>
				</p>
			</div>
			{ isGraphiQLClientEnabled && (
				<>
					<hr/>
					<div className="editor-post-url">
						<h3 className="editor-post-url__link-label">
							🟢 { __( 'GraphiQL client' ) }
						</h3>
						<p>
							<ExternalLink
								className="editor-post-url__link"
								href={ postLink + '?view=graphiql' }
								target="_blank"
							>
								<>
									<span className="editor-post-url__link-prefix">
										{ permalinkPrefix }
									</span>
									<span className="editor-post-url__link-slug">
										{ postSlug }
									</span>
									<span className="editor-post-url__link-suffix">
										{ permalinkSuffix }
									</span>
									<span className="editor-endoint-custom-post-url__link-view">
										{ '?view=' }
									</span>
									<span className="editor-endoint-custom-post-url__link-view-item">
										{ 'graphiql' }
									</span>
								</>
							</ExternalLink>
						</p>
					</div>
				</>
			) }
			{ isVoyagerClientEnabled && (
				<>
					<hr/>
					<div className="editor-post-url">
						<h3 className="editor-post-url__link-label">
							🟢 { __( 'Interactive Schema Client' ) }
						</h3>
						<p>
							<ExternalLink
								className="editor-post-url__link"
								href={ postLink + '?view=schema' }
								target="_blank"
							>
								<>
									<span className="editor-post-url__link-prefix">
										{ permalinkPrefix }
									</span>
									<span className="editor-post-url__link-slug">
										{ postSlug }
									</span>
									<span className="editor-post-url__link-suffix">
										{ permalinkSuffix }
									</span>
									<span className="editor-endoint-custom-post-url__link-view">
										{ '?view=' }
									</span>
									<span className="editor-endoint-custom-post-url__link-view-item">
										{ 'schema' }
									</span>
								</>
							</ExternalLink>
						</p>
					</div>
				</>
			) }
		</>
	);
}
