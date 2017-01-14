from aweber_api import AWeberAPI


class MyApp(object):

    def __init__(self):
        # replace XXX with your keys
        consumer_key = 'Ak7earo480K5alNFbD4LhRIY'
        consumer_secret = '5Ie4rtKyfjXDCTZArq4sBnvS5idGaZyXfZcCtmkO'
        self.access_token = 'Ag9OGz32cbWgY2gR1J1XyOwE'
        self.access_secret = 'taWZFmoDmmKM7DsHsDaKQeJgcPhlfyB0rgZbuyqS'
        self.application = AWeberAPI(consumer_key, consumer_secret)

    def connect_to_AWeber_account(self):
        request_token, token_secret = self.application.get_request_token('oob')
        print 'Go to this url in your browser: %s' % self.application.authorize_url
        code = raw_input('Type code here: ')

        self.application.user.request_token = request_token
        self.application.user.token_secret = token_secret
        self.application.user.verifier = code

        access_token, access_secret = self.application.get_access_token()
        print access_token, access_secret

        return access_token, access_secret

    def find_subscriber(self, **kwargs):
        account = self.application.get_account(self.access_token, self.access_secret)
        print account, account.id

        found_subscribers = account.findSubscribers(**kwargs)
        print found_subscribers

        for subscriber in found_subscribers:
            print subscriber
            print subscriber.name, subscriber.email

            return subscriber

    def find_list(self, **kwargs):
        account = self.application.get_account(self.access_token, self.access_secret)
        print account.lists

        found_lists = account.lists.find(**kwargs)
        print found_lists

        for _list in found_lists:
            print _list
            print _list.name, _list.id

            return _list

    def add_subscriber(self, subscriber, _list):
        account = self.application.get_account(self.access_token, self.access_secret)

        list_url = '/accounts/%s/lists/%s' % (account.id, _list.id)
        _list = account.load_from_url(list_url)

        try:
            _list.subscribers.create(**subscriber)

        except Exception, exc:
            print exc


app = MyApp()

#app.connect_to_AWeber_account()

app.find_subscriber(email='hoai@acong.vn')

_list = app.find_list()

subscriber = {
    'email': 'johndoe@example.com',
    'name': 'John Doe',
}

#app.add_subscriber(subscriber, _list)
