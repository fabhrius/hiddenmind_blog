<?php
namespace APB\Inc;

class Functions{	
	static function filterNaN( $array ) {
		return array_filter( $array, function( $id ) {
			return $id && is_numeric( $id );
		});
	}

	static function wordCount( $content ) {
		return $content ? count( preg_split( '/[\s]+/', strip_tags( $content ) ) ) : 0;
	}

	static function arrangedPosts ( $posts, $postType, $fImgSize = 'full', $metaDateFormat = 'M j, Y' ) {
		$arranged = [];

		$taxOfPostType = array_diff( get_object_taxonomies( $postType ), array( 'post_format', 'category' ) );

		foreach( $posts as $post ){
			$id = $post->ID;
			$content = preg_replace( '/(<([^>]+)>)/i', '', $post->post_content ); // Can use strip_tags also
			$contentWords = self::wordCount( $content );

			$thumbnail = [
				'url' => get_the_post_thumbnail_url( $post, $fImgSize ),
				'alt' => get_post_meta( get_post_thumbnail_id( $id ), '_wp_attachment_image_alt', true )
			];

			$taxonomies = [];
			foreach ( $taxOfPostType as $key => $slug ) {
				$terms = wp_get_post_terms( $id, $slug );

				$links = '';
				foreach( $terms as $index => $t ){
					$link = get_term_link( $t->slug, $slug );
					$terms[$index]->link = $link;

					$links .= "<a href='$link' rel='$slug'>$t->name</a>";
				};
				$taxonomies[$slug] = $links;
			}

			$arranged[] = [
				'id' => $id,
				'link' => get_permalink( $post ),
				'name' => $post->post_name,
				'thumbnail' => $thumbnail,
				'title' => $post->post_title,
				'excerpt' => $post->post_excerpt,
				'content' => $content,
				'author' => [
					'name' => get_the_author_meta( 'display_name', $post->post_author ),
					'link' => get_author_posts_url( $post->post_author )
				],
				'date' => $post->post_date,
				'date' => get_the_date( $metaDateFormat, $id ),
				'dateGMT' => $post->post_date_gmt,
				'modifiedDate' => $post->post_modified,
				'modifiedDateGMT' => $post->post_modified_gmt,
				'commentCount' => $post->comment_count,
				'commentStatus' => $post->comment_status,
				'categories' => [
					'coma' => get_the_category_list( esc_html__( ', ' ), '', $id ),
					'space' => get_the_category_list( esc_html__( ' ' ), '', $id )
				],
				'taxonomies' => $taxonomies,
				'readTime' => [
					'min' => floor( $contentWords / 200 ),
					'sec' => floor( $contentWords % 200 / ( 200 / 60 ) )
				],
				'status' => $post->post_status
			];
		}

		return $arranged;
	}
}