
def message(token):
    from .prompt import counter
    print('yes')
    count = counter(token)
    print(f"the term {token} shows up in the corpus {count} times")
