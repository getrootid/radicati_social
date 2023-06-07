<?php

namespace Drupal\radicati_social\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class RadicatiSocialConfigForm extends ConfigFormBase {
    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return "radicati_social_config_form";
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return ["radicati_social.settings"];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
      $config = $this->config("radicati_social.settings");

      $defaultServices = $config->get('available_services');
      $servicesOrder = $config->get("services", []);

      if(!empty($servicesOrder)) {
        foreach($defaultServices as $key => $service) {
          $services[$key] = array_merge($service, $servicesOrder[$key]);
        }
      } else {
        $services = $defaultServices;
      }

      // Sort services by weight
      uasort($services, function($a, $b) {
        if ($a['weight'] == $b['weight']) {
          return 0;
        }
        return ($a['weight'] < $b['weight']) ? -1 : 1;
      });


      // Label displayed next to sharing buttons
      $form['label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Share Label'),
        '#default_value' => $config->get('label'),
        '#description' => $this->t('The label to display next to the sharing buttons.'),
      ];

      $form['services'] = [
        '#type' => 'table',
        '#header' => [
          $this->t('Service'),
          $this->t('Enabled'),
          $this->t('Icon Class'),
          $this->t('Order'),
        ],
        '#tabledrag' => [
          [
            'action' => 'order',
            'relationship' => 'sibling',
            'group' => 'weight',
          ],
        ],
      ];
      foreach($services as $key => $service) {
        $form['services'][$key]['#attributes']['class'][] = 'draggable';
        $form['services'][$key]['#weight'] = $service['order'];

        $form['services'][$key]['label'] = [
          '#type' => 'markup',
          '#markup' => $service['label'],
        ];
        $form['services'][$key]['enabled'] = [
          '#type' => 'checkbox',
          '#default_value' => $service['enabled'],
        ];
        $form['services'][$key]['class'] = [
          '#type' => 'textfield',
          '#default_value' => $service['class'],

        ];


        $form['services'][$key]['weight'] = [
          '#type' => 'weight',
          '#title' => $this->t('Weight'),
          '#title_display' => 'invisible',
          '#default_value' => $service['weight'],
          '#attributes' => ['class' => ['weight']],
        ];
      }

      $form['#attached']['library'][] = 'core/drupal.tabledrag';

      $form['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Save'),
      ];

      return $form;
    }

    /**
     * Handle form submissions
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
      $config = $this->config("radicati_social.settings");
      $services = $form_state->getValue('services');

      $config->set('label', $form_state->getValue('label'));
      $config->set('services', $services);
      $config->save();
      parent::submitForm($form, $form_state);
    }
}