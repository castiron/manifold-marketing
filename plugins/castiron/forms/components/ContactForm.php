<?php namespace Castiron\Forms\Components;

use Cms\Classes\ComponentBase;
use Castiron\Forms\Models\Contact;
use Castiron\Forms\Models\ContactConfig;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Backend\Facades\Backend;

class ContactForm extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'ContactForm Component',
            'description' => 'Renders the homepage Contact form'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    /**
     * @var array Field validation rules
     */
    protected $rules = [
        'name'          => ['required'],
        'email'         => ['required', 'email'],
        'organization'  => ['required'],
        'body'          => ['required']
    ];

    /**
     * @var bool
     */
    protected $confirmed = false;

    protected $errors;

    /**
     * @return mixed
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * @return mixed|bool
     */
    public function onSubmit() {
        $input = Input::all();

        // Truncate inputs at 200 characters
        foreach($input as $key => &$value) {
            $input[$key] = substr($value, 0, 200);
        }

        $validator = Validator::make($input, $this->rules);

        if($validator->fails()) {
            $this->errors = $validator->errors()->toArray();
            return false;
        }
        $this->confirmed = true; // Used to determine if the form was valid

        $newContact = Contact::create($input);

        Mail::send('castiron.forms::mail.contact-message', [
            'name'          => $input['name'],
            'email'         => $input['email'],
            'organization'  => $input['organization'],
            'body'          => $input['body'],
            'url'           => Backend::url('castiron/forms/contacts/update/' . $newContact->id)
        ], function($message) {
            $message->to(env('NOTIFICATION_CONTACT_EMAIL'));
        });

        if ($this->confirmed) {
            return ['#success' => $this->renderPartial('contactform::success')];
        }
    }
}
