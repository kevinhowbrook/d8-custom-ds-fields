<?php
namespace Drupal\custom_dsfields\Plugin\DsField;
use Drupal\ds\Plugin\DsField\DsFieldBase;
use Drupal\user\Entity\User;
//Views
/**
 * Plugin that renders the field.
 *
 * @DsField(
 *   id = "date_author",
 *   title = @Translation("Publish date and Author"),
 *   entity_type = "node",
 *   provider = "custom_dsfields",
 *   
 * )
 */

class DateAuthor extends DsFieldBase
{
	/**
	* {@inheritdoc}
	*/

	public function build(){
        //cast the node info to an array otherwise the array is massive
		$node = $this->entity()->toArray();
        //kint($node);
        $date = $this->entity()->created->value;
        $date = \Drupal::service('date.formatter')->format($date, 'simple', $format = '', $timezone = NULL, $langcode = NULL);
        $author = $this->entity()->uid->target_id;
        //Load the author
        //or you can use $account = \Drupal\user\Entity\User::load($author);
        $account = User::load($author);
        $name = $account->getUsername();
        if(empty($name)){
            $name = 'Anonymous';
        }
        //kint($account->toArray());
		  return array(
				'#markup' => $date . t(' by ') . $name
		  	// '#theme' => 'item_list',
			);
	}
}