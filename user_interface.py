
def message(token):
    from .prompt import counter
    count = counter(token)
    print(count)
    return print(f"the term {token} shows up in the corpus {count} times")
