
def message(token):
    from .prompt import counter
    count = counter(token)
    print('yay')
    return print(f"the term {token} shows up in the corpus {count} times")
    
