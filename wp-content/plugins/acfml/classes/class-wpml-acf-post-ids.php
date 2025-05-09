<?php

class WPML_ACF_Post_Ids implements WPML_ACF_Convertable {

	/**
	 * @param WPML_ACF_Field $acf_field
	 *
	 * @return string[]|string - should always be string[], string only when:
	 *  - meta_value is "serialized"
	 *  - exception Field Type - Page Object - Select Single (input is single string number)
	 */
	public function convert( WPML_ACF_Field $acf_field ) {
		return $this->convertSerializationLayer( $acf_field );
	}

	/**
	 * @param WPML_ACF_Field $acf_field
	 *
	 * @return string[]|string
	 */
	private function convertSerializationLayer( WPML_ACF_Field $acf_field ) {
		$came_serialized = is_serialized( $acf_field->meta_value );

		$mixedIds = $came_serialized
			? maybe_unserialize( $acf_field->meta_value )
			: $acf_field->meta_value;

		$mixedTranslatedIds = $this->convertStringOrArrayOfStringsLayer( $mixedIds, $acf_field );

		return $came_serialized
			? serialize( $mixedTranslatedIds )
			: $mixedTranslatedIds;
	}

	/**
	 * @param array|string|int $mixedIds
	 * @param WPML_ACF_Field $acf_field
	 *
	 * @return string[]|string
	 */
	private function convertStringOrArrayOfStringsLayer( $mixedIds, WPML_ACF_Field $acf_field ) {

		if ( is_array( $mixedIds ) ) {
			return array_map( function ( string $originalId ) use ( $acf_field ) {
				return $this->convertOriginalIdToTranslationId( $originalId, $acf_field );
			}, $mixedIds );
		}

		return $this->convertOriginalIdToTranslationId( $mixedIds, $acf_field );
	}

	private function convertOriginalIdToTranslationId( string $originalId, WPML_ACF_Field $acf_field ): string {
		return (string) ( new WPML_ACF_Post_Id( $originalId, $acf_field ) )
			->convert()->id;
	}
}
