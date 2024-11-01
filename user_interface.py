
def message(token):
    from .prompt import counter
    count = counter(token)
    return f"the term {token} shows up in the corpus {count} times"
