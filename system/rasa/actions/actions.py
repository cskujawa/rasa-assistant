from rasa_sdk import Action, Tracker
from rasa_sdk.types import DomainDict
from rasa_sdk.events import SlotSet
from rasa_sdk.executor import CollectingDispatcher
from typing import Any, Dict, List, Text
import requests
import os
from requests import Session


class ActionHomeAutomation(Action):

    # Name the action, required
    def name(self) -> Text:
        return 'action_home_automation'

    # Main process
    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker,
            domain: DomainDict) -> List[Dict[Text, Any]]:
        #  Retrieve slot values assigned by rasa
        state = tracker.get_slot('state')
        device = tracker.get_slot('device')

        # Check slots were assigned
        if state is None:
            dispatcher.utter_message(
                "I don't know what you want me to do with your device...")
            return [SlotSet('state', 'none')]
        if device is None:
            dispatcher.utter_message(
                "I don't know what you want me to do...")
            return [SlotSet('state', 'none')]

        # Set required headers for homeassistant requests
        headers = {
            'Authorization': os.environ.get('HOMEASSISTANT_TOKEN'),
            'Content-Type': 'application/json'
        }

        # Format the device name
        device_name = "switch.{}".format(device)
        device_name = device_name.replace(" ", "_")
        # Assemble URL
        url = 'http://homeassistant:8123/api/services/switch/turn_{}'.format(state)
        # Post request to homeassistant container
        response = requests.post(
            url,
            headers=headers,
            json={"entity_id": device_name})

        dispatcher.utter_message("Thy will be done...")
        return [SlotSet('state', 'none')]