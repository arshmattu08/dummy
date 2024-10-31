from .counter import counter

def message(token):
    count = counter(token)
    return f"the term {token} shows up in the corpus {count} times"
